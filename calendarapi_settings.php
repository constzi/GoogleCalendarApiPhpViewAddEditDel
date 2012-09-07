<?php

// *** Calendar service instance
$path = '[PATH THAT POINTS TO ZEND LIBRARY]';
$oldPath = set_include_path(get_include_path() . PATH_SEPARATOR . $path);

require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_Calendar');

// User whose calendars you want to access
$user = '[USERNAME]@gmail.com';
$pass = '[PASSWORD]';
$service = Zend_Gdata_Calendar::AUTH_SERVICE_NAME; // predefined service name for calendar
$client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $service);
$service = new Zend_Gdata_Calendar($client);

date_default_timezone_set('America/Los_Angeles');
?>
