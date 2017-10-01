<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 25.9.17
 * Time: 12:10
 */
namespace Articles\Command;

use Articles\Model\Model\System;
use Articles\Model\Model\User;
use Articles\Model\Model\Webmaster;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddUserCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:addUser")->addArgument("email", InputArgument::REQUIRED, "E-mail")
            ->addArgument("nickName", InputArgument::REQUIRED, "Nickname of the user");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $system = $this->createSystem();
        $email = $input->getArgument("email");
        $nickName = $input->getArgument("nickName");
        $user = new User($email, $nickName);
        $system->registerUser($user);
        $output->writeln("The new user has ID ".$user->getId());
    }
}