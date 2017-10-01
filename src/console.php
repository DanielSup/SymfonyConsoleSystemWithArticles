<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30.9.17
 * Time: 9:24
 */

require "autoloader.php";
require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();
$commands = scandir("./Articles/Command");
foreach ($commands as $command){
    if(!is_dir($command)) {
        $name = explode(".", $command);
        $className = "Articles\\Command\\" . $name[0];
        $application->add(new $className());
    }
}
while(true) {
    $application->run();
}