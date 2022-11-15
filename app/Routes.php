<?php

class HttpMethod
{
    static $GET = 'GET';
    static $POST = 'POST';
    static $PATCH = 'PATCH';
    static $DELETE = 'DELETE';
}

class Role
{
    static $admin = 'admin';
    static $manager = 'manager';
    static $corporate = 'corporate';
    static $student = 'student';
    static $teacher = 'teacher';
}

use app\SimpleRooting;

$config = include __DIR__ . './../config.php';

$routes = new SimpleRooting($config['prefix'], $config['fullRest']);

$routes->addSimple('/user', 'Users', 'getUser', HttpMethod::$GET);
$routes->addSimple('/user/logout', 'Users', 'logoutUser', HttpMethod::$GET);

$routes->addSimple('/users', 'Users', 'getList', HttpMethod::$GET,
    ["admin", "manager"]);
$routes->addSimple('/users', 'Users', 'addUser', HttpMethod::$POST,
    ["admin"]);
$routes->addSimple('/users/{id}', 'Users', 'getUserById', HttpMethod::$GET,
    ["admin", "manager", "corporate" => [
        'id' => 'userId'
    ]]);
$routes->addSimple('/users/{id}', 'Users', 'editUser', HttpMethod::$PATCH,
    ["admin"]);
$routes->addSimple('/users/{id}', 'Users', 'deleteUser', HttpMethod::$DELETE,
    ["admin"]);

$routes->addSimple('/auth', 'Users', 'authUser', HttpMethod::$POST);

$routes->addSimple('/ping', 'Ping', 'ping', HttpMethod::$GET);

$routes->addSimple('/log', 'Logger', 'log', HttpMethod::$GET);

return $routes;
