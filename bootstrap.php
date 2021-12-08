<?php
require "vendor/autoload.php";

use App\Josep\Config;
use App\Registry;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;


$configXML = new \App\Alex\Config('config.xml');
$configJson = new \App\Josep\Config('config.json');

Registry::setPDO($configXML);
//Registry::setPDO($configJson);

// create a log channel
$log = new Logger('movies');
$log->pushHandler(new StreamHandler('app.log', Logger::DEBUG));
$log->pushHandler(new FirePHPHandler());
Registry::set(Registry::LOGGER, $log);
