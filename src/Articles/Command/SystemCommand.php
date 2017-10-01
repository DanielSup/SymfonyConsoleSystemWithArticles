<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30.9.17
 * Time: 9:40
 */

namespace Articles\Command;

use Articles\Model\Exception\NoSuchUserException;
use Articles\Model\Model\System;
use Articles\Model\Model\User;
use Articles\Model\Model\Webmaster;
use Articles\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SystemCommand extends Command
{
    protected static $user = null;

    protected function configure()
    {
        $this->setName("articles:SystemCommand");
        $webmaster = null;
        try {
            $webmaster = Webmaster::find(1);
        } catch (NoSuchUserException $ex){
            $webmaster = new Webmaster("email@seznam.cz", "webmaster");
        }
        $system = System::getInstance($webmaster);
        static::$user = UserService::getInstance($system)->getLoggedUser();
    }
    protected function createSystem(){
        $webmaster = Webmaster::find(1);
        $system = System::getInstance($webmaster);
        return $system;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
    }
}