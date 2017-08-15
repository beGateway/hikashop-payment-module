<?php
/**
 * @package	beGateway for HikaShop for Joomla!
 * @version	1.0.0
 * @author	ecomcharge.com
 * @copyright	(C) 2013-2017 eComCharge Ltd SIA. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><div class="hikashop_begateway_end" id="hikashop_begateway_end">
	<span id="hikashop_begateway_end_message" class="hikashop_begateway_end_message">
		<?php echo JText::sprintf('PLEASE_WAIT_BEFORE_REDIRECTION_TO_X', $this->payment_name).'<br/>'. JText::_('CLICK_ON_BUTTON_IF_NOT_REDIRECTED');?>
	</span>
	<span id="hikashop_begateway_end_spinner" class="hikashop_begateway_end_spinner hikashop_checkout_end_spinner">
	</span>
	<br/>
	<form id="hikashop_begateway_form" name="hikashop_begateway_form" action="<?php echo $this->vars['url'];?>" method="post">
		<div id="hikashop_begateway_end_image" class="hikashop_begateway_end_image">
			<input id="hikashop_begateway_button" type="submit" class="btn btn-primary" value="<?php echo JText::_('PAY_NOW');?>" name="" alt="<?php echo JText::_('PAY_NOW');?>" />
		</div>
<?php
		echo '<input type="hidden" name="token" value="'.htmlspecialchars((string)$this->vars['token']).'" />';
	JRequest::setVar('noform',1);
?>
	</form>
	<script type="text/javascript">
	<!--
	document.getElementById('hikashop_begateway_form').submit();
	//-->
	</script>
</div>
