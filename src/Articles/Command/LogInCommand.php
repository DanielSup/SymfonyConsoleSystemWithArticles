<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 25.9.17
 * Time: 12:10
 */
namespace Articles\Command;

use Articles\Model\Exception\NoSuchUserException;
use Articles\Model\Model\ActiveUser;
use Articles\Model\Model\System;
use Articles\Model\Model\User;
use Articles\Model\Model\Webmaster;
use Articles\Service\UserService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LogInCommand extends SystemCommand
{
    public static $array = array("u" => "User", "au" => "ActiveUser", "ad" => "Administrator", "w" => "Webmaster");
    protected function configure()
    {
        $this->setName("articles:logUser")->addArgument("id", InputArgument::REQUIRED, "ID of the user.")->
        addArgument("type", InputArgument::REQUIRED, "Type of the user (u = User, au = ActiveUser, ad = Administrator,
        w = Webmaster)");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try{
            $idInteger = intval($input->getArgument("id"));
            if(!in_array($input->getArgument("type"), array_keys(self::$array))){
                $output->writeln("Value of type is invalid.");
                return;
            }
            $className = "Articles\\Model\\Model\\".self::$array[$input->getArgument("type")];
            $user = $className::find($idInteger);
            $service = UserService::getInstance($this->createSystem());
            self::$user = $user;
            $service->logUser($idInteger, $input->getArgument("type"));
        } catch(NoSuchUserException $ex){
            $output->writeln("User with ID ".$input->getArgument("id")." wasn't found.");
        }
    }
}