<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25.9.17
 * Time: 12:11
 */

namespace Articles\Command;

use Articles\Model\Exception\NoSuchUserException;
use Articles\Model\Model\System;
use Articles\Model\Model\User;
use Articles\Model\Model\Webmaster;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BanUserCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:banUser")->addArgument("userID", InputArgument::REQUIRED, "ID of the user who will be banned");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(empty(self::$user)){
            $output->writeln("You must log in to ban an user");
            return;
        }
        if(!(self::$user instanceof Webmaster)){
            $output->writeln("You must be the webmaster in to ban an user");
            return;
        }
        $system = System::getInstance(self::$user);
        $id = intval($input->getArgument("userID"));
        try{
            $user = User::find($id);
            $system->banUser($user);
            $output->writeln("User with ID ".$id." was successfully banned.");
        } catch(NoSuchUserException $ex){
            $output->writeln("User with ID ".$input->getArgument("userID")." wasn't found.");
        }
    }
}