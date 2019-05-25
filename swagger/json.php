<?php

require("../vendor/autoload.php");

$json = \Swagger\scan(__DIR__ . '/../app');
header('Content-Type: application/json');
echo $json;