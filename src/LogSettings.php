<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 1.10.17
 * Time: 7:46
 */
require_once "../vendor/autoload.php";
include_once "./autoloader.php";

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LogSettings
{
    public static function setLogging(){
        error_reporting(0);
        ini_set("log_errors", 1);
        $file = "./error.log";
        ini_set("error_log", $file);
        $logger = new Logger("name");
        \Monolog\ErrorHandler::register($logger);
        $logger->pushHandler(new StreamHandler($file, Logger::ERROR, false));
    }
}