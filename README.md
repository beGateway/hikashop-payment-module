[Русская версия](#Модуль-оплаты-begateway-для-joomla-253x-и-hikashop)

# beGateway payment module for Joomla 2.5/3.x and HikaShop

## System requirements

* PHP 5.3+
* [cURL extension](http://php.net/manual/en/book.curl.php)
* [Joomla](http://www.joomla.org/download.html) (the module was tested with version 3.4.8)
* [HikaShop](https://www.hikashop.com/) (the module was tested with version 3.1.1)

## The module installation

1. [Download plg_hikashoppayment_begateway.zip](https://github.com/beGateway/hikashop-payment-module/blob/master/plg_hikashoppayment_begateway.zip?raw=true)
2. Go to Joomla's administration panel
3. Go to _Manage_ page via the menu _Extensions_
4. Install the module package
  1. Open the page _Install_ and the tab _Upload Package File_
  2. Select the module package file saved at the step 1.
  3. Click _Upload & Install_ to install the module
  4. Go to _Plugins_ via the menu _Extensions_
  5. Locate the plugin _HikaShop beGateway payment plugin_ and enable it

## The module configuration

1. Go to Joomla's administration panel
2. Go to HikaShop's administration panel via _Components_ -> _HikaShop_ -> _Configuration_
3. Go to the menua _System_ -> _Payment methods_
4. Click the button _New_ and select _HikaShop beGateway payment plugin_
5. Configure the module
  1. Setup the payment method name
  2. Locate the block _Specific configuration_
  3. Enter the module settings
  4. Click _Save & Close_
6. Publish the payment method
  1. Select the configured payment method in the list of payment methods
  2. Publish it by clicking an icon in the column _Published_

## Test data

If you setup the module with values as follows:

  * Checkout domain __checkout.begateway.com__
  * Shop Id __361__
  * Shop secret key __b8647b68898b084b836474ed8d61ffe117c9a01168d867f24953b776ddcb134d__

Then you can use the test data to make a test payment:

* card number __4200000000000000__
* card name __JOHN DOE__
* card expiry __01/30__ to get a success payment
* card expiry __10/30__ to get a failed payment
* CVC __123__

[English version](#begateway-payment-module-for-joomla-253x-and-hikashop)

# Модуль оплаты beGateway для Joomla 2.5/3.x и HikaShop

## Системные требования

* PHP 5.3+
* [cURL](http://php.net/manual/en/book.curl.php)
* [Joomla](http://www.joomla.org/download.html) 3.x (модуль был разработан и протестирован с версией 3.4.8)
* [HikaShop](https://www.hikashop.com/) (модуль был разработан и протестирован с версией 3.1.1)

## Установка

1. [Скачайте plg_hikashoppayment_begateway.zip](https://github.com/beGateway/hikashop-payment-module/blob/master/plg_hikashoppayment_begateway.zip?raw=true)
2. Зайдите в панель администратора Joomla
3. Через меню _Расширения_ перейдите в _Менеджер расширений_
4. Установите пакет
  1. Откройте страницу _Установка_ и закладку _Загрузить файл пакета_
  2. Выберите файл архива модуля, скаченного на шаге 1
  3. Нажмите _Загрузить и установить_, чтобы установить модуль
  4. Через меню _Расширения_ перейдите в _Менеджер плагинов_
  5. Найдите плагин _HikaShop beGateway payment plugin_ и включите его

## Настройка модуля

1. Зайдите в панель администратора Joomla
2. Зайдите в панель администратора HikaShop через _Компоненты_ -> _HikaShop_ -> _Конфигурация_
3. Перейдите в меню _Система_ -> _Способы оплаты_
4. Нажмите кнопку _Создать_ и выберите _HikaShop beGateway payment plugin_
5. Настройте модуль
  1. Задайте название способа оплаты
  2. Найдите блок _Специальная конфигурация_
  3. Введите настройки модуля
  4. Нажмите _Сохранить и закрыть_
6. Опубликуйте способ оплаты
  1. Выберите настроенный способ оплаты в списке доступных способов оплаты
  2. Опубликуйте его, кликнув на иконку в колонке _Опубликовать_

## Тестовые данные

Если вы настроите модуль со следующими значениями

  * Домен страницы оплаты __checkout.begateway.com__
  * Id магазина __361__
  * Секретный ключ магазина __b8647b68898b084b836474ed8d61ffe117c9a01168d867f24953b776ddcb134d__

то вы сможете уже осуществить тестовый платеж в вашем магазине.

Используйте следующие данные тестовой карты:

  * номер карты __4200000000000000__
  * имя на карте __JOHN DOE__
  * срок действия карты __01/30__, чтобы получить успешный платеж
  * срок действия карты __10/30__, чтобы получить неуспешный платеж
  * CVC __123__
