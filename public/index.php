<?php
declare(strict_types=0);
session_start();
require __DIR__ . '/../bootstrap.php';


$prefix = "App\\Controller\\";

$match = $router->match();

//var_dump($match);

if (is_array($match)) {
    $target = explode("#", $match["target"]);
    $controller = $prefix . $target[0];
    $method = $target[1];
    if (method_exists($controller, $method)) {
        $object = new $controller;
        $response = call_user_func_array([$object, $method], $match['params']);

        $response->writeHeaders();
        echo $response->render();
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


