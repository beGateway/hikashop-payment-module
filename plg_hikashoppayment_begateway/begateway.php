<?php
/**
 * @package	beGateway for HikaShop for Joomla!
 * @version	1.0.0
 * @author	ecomcharge.com
 * @copyright	(C) 2013-2017 eComCharge Ltd SIA. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');

require_once __DIR__ . '/lib/begateway-api-php/lib/beGateway.php';

?><?php
class plgHikashoppaymentBeGateway extends hikashopPaymentPlugin
{
	var $accepted_currencies = array(
  'USD','EUR','GBP','AUD','CAD','JPY','AED','AFN','ALL','AMD','ANG',
  'AOA','ARS','AWG','AZN','BAM','BBD','BDT','BGN','BHD','BIF','BMD','BND',
  'BOB','BRL','BSD','BTC','BTN','BWP','BYN','BZD','CDF','CHF','CLF','CLP',
  'CNY','COP','CRC','CUC','CUP','CVE','CZK','DJF','DKK','DOP','DZD','EEK',
  'EGP','ERN','ETB','FJD','FKP','GEL','GGP','GHC','GHS','GIP','GMD','GNF',
  'GTQ','GYD','HKD','HNL','HRK','HTG','HUF','IDR','ILS','IMP','INR','IQD',
  'IRR','ISK','JEP','JMD','JOD','KES','KGS','KHR','KMF','KPW','KRW','KWD',
  'KYD','KZT','LAK','LBP','LKR','LRD','LSL','LTL','LVL','LYD','MAD','MDL',
  'MGA','MKD','MMK','MNT','MOP','MRO','MTL','MUR','MVR','MWK','MXN','MYR',
  'MZN','NAD','NGN','NIO','NOK','NPR','NZD','OMR','PAB','PEN','PGK','PHP',
  'PKR','PLN','PYG','QAR','RON','RSD','RUB','RWF','SAR','SBD','SCR','SDG',
  'SEK','SGD','SHP','SKK','SLL','SOS','SRD','SSP','STD','SVC','SYP','SZL',
  'THB','TJS','TMM','TMT','TND','TOP','TRY','TTD','TWD','TZS','UAH','UGX',
  'UYU','UZS','VEF','VND','VUV','WST','XAF','XAG','XAU','XCD','XDR','XOF',
  'XPF','YEN','YER','ZAR','ZMK','ZMW','ZWD','ZWL','ZWN','ZWR');

	var $multiple = true;
	var $name = 'begateway';

	var $pluginConfig = array(
		'shop_id' => array('BEGATEWAY_SHOP_ID', 'input'),
		'shop_key' => array('BEGATEWAY_SHOP_KEY', 'input'),
		'domain_checkout' => array('BEGATEWAY_DOMAIN_CHECKOUT', 'input'),
		'invalid_status' => array('INVALID_STATUS', 'orderstatus'),
		'pending_status' => array('PENDING_STATUS', 'orderstatus'),
		'verified_status' => array('VERIFIED_STATUS', 'orderstatus'),
		'ordervalidity' => array('BEGATEWAY_VALIDITY', 'input')
	);

	public function __construct(&$subject, $config)
	{
		//Load language file.
		JPlugin::loadLanguage('plg_hikashoppayment_begateway', JPATH_ADMINISTRATOR);

		parent::__construct($subject, $config);
	}

	function onAfterOrderConfirm(&$order, &$methods, $method_id)
	{
		parent::onAfterOrderConfirm($order, $methods, $method_id);

		if (empty($this->payment_params->ordervalidity)) {
			$this->payment_params->ordervalidity = 1;
		}

		if (empty($this->payment_params->shop_id))
		{
			$this->app->enqueueMessage(JText::_('BEGATEWAY_ERROR_SHOP_ID'),'error');
			return false;
		}

		if (empty($this->payment_params->shop_key))
		{
			$this->app->enqueueMessage(JText::_('BEGATEWAY_ERROR_SHOP_KEY'),'error');
			return false;
		}

		if (empty($this->payment_params->domain_checkout))
		{
			$this->app->enqueueMessage(JText::_('BEGATEWAY_ERROR_DOMAIN_CHECKOUT'),'error');
			return false;
		}

		$amount = round($order->cart->full_total->prices[0]->price_value_with_tax, 2);

		$notify_url = HIKASHOP_LIVE . 'index.php?option=com_hikashop&ctrl=checkout&task=notify&notif_payment=begateway&tmpl=component' . $this->url_itemid;
		$return_url = HIKASHOP_LIVE . 'index.php?option=com_hikashop&ctrl=checkout&task=after_end&order_id='.$order->order_id.$this->url_itemid;
    $notify_url = str_replace('carts.local', 'webhook.begateway.com:8443', $notify_url);

    $token = new \beGateway\GetPaymentToken();
    $token->money->setAmount($amount);
    $token->money->setCurrency($this->currency->currency_code);
    $token->setExpiryDate(date("Y-m-d", ((int)$this->payment_params->ordervalidity+1)*24*3600 + time()) . "T00:00:00+00:00");
    $token->setTrackingId($order->order_id . '|' . $this->user->user_id);
    $token->setDescription(JText::_('BEGATEWAY_ORDER') . ' ' . $order->order_number);
    $token->setLanguage($this->_getLanguage($this->locale));
    $token->setNotificationUrl($notify_url);
    $token->setSuccessUrl($return_url);
    $token->setDeclineUrl($return_url);
    $token->setFailUrl($return_url);

    $token->customer->setFirstName(@$order->cart->billing_address->address_firstname);
    $token->customer->setLastName(@$order->cart->billing_address->address_lastname);
    $token->customer->setCountry($order->cart->billing_address->address_country->zone_code_2);
    $token->customer->setAddress($order->cart->billing_address->address_street);
    $token->customer->setCity($order->cart->billing_address->address_city);
    $token->customer->setZip(@$order->cart->shipping_address->address_post_code);

    $token->customer->setEmail($this->user->user_email);

    if (in_array($order->cart->billing_address->address_country->zone_code_2, array('US', 'CA') )) {
      $token->customer->setState($order->cart->billing_address->address_state->zone_name);
    }
    $token->setAddressHidden();

    \beGateway\Settings::$shopId = $this->payment_params->shop_id;
    \beGateway\Settings::$shopKey = $this->payment_params->shop_key;
    \beGateway\Settings::$checkoutBase = 'https://' . $this->payment_params->domain_checkout;

    $response = $token->submit();

    if ($response->isSuccess()) {
      $vars = array(
        'token' => $response->getToken(),
        'url' => $response->getRedirectUrlScriptName()
      );
    } else {
      $this->app->enqueueMessage(JText::_('BEGATEWAY_ERROR_TOKEN'),'error');
      return false;
    }

		$this->vars = $vars;
		return $this->showPage('end');
	}

	function getPaymentDefaultValues(&$element)
	{
		$element->payment_name = 'begateway';
		$element->payment_description = JText::_('You can pay by credit card using this payment method');
		$element->payment_images = 'MasterCard,VISA';
		$element->payment_params->url = '';
		$element->payment_params->ordervalidity = 1;
		$element->payment_params->invalid_status = 'cancelled';
		$element->payment_params->verified_status = 'confirmed';
		$element->payment_params->pending_status = 'created';
	}

  function _getLanguage($lang) {
    return substr($lang,0,2);
  }

	function onPaymentNotification(&$statuses)
	{
    $webhook = new \beGateway\Webhook;

		list($order_id, $user_id) = explode('|', $webhook->getTrackingId());
    $order_id = intval($order_id);
    $user_id = intval($user_id);
    $dbOrder = $this->getOrder($order_id);

    $this->loadPaymentParams($dbOrder);
    if(empty($this->payment_params))
      return false;

    $this->loadOrderData($dbOrder);

    \beGateway\Settings::$shopId = $this->payment_params->shop_id;
    \beGateway\Settings::$shopKey = $this->payment_params->shop_key;

    if ($webhook->isAuthorized()) {
      $history = new stdClass();
  		$history->notified = 1;
  		$history->data = '';

      $history->data .= "\n\n" . 'payment with UID ' . $webhook->getUid();

  		if ($webhook->isFailed())
  		{
  			$this->modifyOrder($order_id, $this->payment_params->invalid_status, $history, true);
  			return false;
  		}

  		if ($webhook->isSuccess())
  		{
  			$order_status = $this->payment_params->verified_status;
  		}
  		else if ($webhook->isIncomplete() || $webhook->isPending())
  		{
  			$order_status = $this->payment_params->pending_status;
  		}

  		if ($dbOrder->order_status == $order_status)
  		{
  			return true;
  		}

  		if (!empty($order_status))
  		{
  			$this->modifyOrder($order_id, $order_status, $history, true);
  		}

  		return true;
    }
	}
}
