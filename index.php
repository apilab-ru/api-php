<?php

session_start();
include "app/Autoloader.php";
require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing;

$request = Request::createFromGlobals();
$routes = include __DIR__ . '/app/Routes.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

try {
    $res = $matcher->match($request->getPathInfo());
} catch (Exception $e) {
    header("HTTP/1.0 404 Not Found");
    die("Нет такой страницы совсем");
}

(new app\App(include "config.php", include "app/Access.php"))->run($res, $_REQUEST);
