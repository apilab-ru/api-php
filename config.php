<?php

error_reporting(1);
ini_set('mysql.connect_timeout', 100000);
date_default_timezone_set('Europe/Samara');

return array(
    'db' => array(
        'user'  => 'root',
        'pass'  => '',
        'host'  => 'localhost',
        'table' => 'crm-lang'
    ),
    'dev' => 0,
    'defUser' => 0,
    'prefix' => '/',
    'fullRest' => true,
	'delivery' => [
		'period' => 300,
		'count' => 100,
		'set' => [
			'token' => '7e3d728e9b993f9a8796908b90196e3b'
		]
	]
);
