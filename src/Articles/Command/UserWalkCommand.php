<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30.9.17
 * Time: 16:28
 */

namespace Articles\Command;

use Articles\Service\UserService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserWalkCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:userWalk");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $service = UserService::getInstance($this->createSystem());
        $users = $service->getUser();
        foreach ($users as $user){
            $output->writeln($user->getId());
            $output->writeln($user->getEmail());
            $output->writeln($user->getNickName());
        }
    }
}