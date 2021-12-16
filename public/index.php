<?php
declare(strict_types=0);
session_start();
require __DIR__ . '/../bootstrap.php';


$prefix = "App\\Controller\\";

$match = $router->match();

var_dump($match);

if (is_array($match)) {
    $temp = explode("#", $match["target"]);
    $controller = $prefix . $temp[0];
    $action = $temp[1];
    if (method_exists($controller, $action)) {
        $object = new $controller;
        call_user_func_array([$object, $action], $match['params']);
    } else {
        // no route was matched
        header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        echo "error";
    }
} else {
    // no route was matched
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    echo "error";
}


