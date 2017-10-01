<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 28.9.17
 * Time: 9:25
 */

function my_autoloader($class) {
    include './' . str_replace("\\", "/", $class) . '.php';
}

spl_autoload_register('my_autoloader');

// Or, using an anonymous function as of PHP 5.3.0
spl_autoload_register(function ($class) {
    include './' . str_replace("\\", "/", $class) . '.php';
});