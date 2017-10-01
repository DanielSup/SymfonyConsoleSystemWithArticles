<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25.9.17
 * Time: 12:11
 */

namespace Articles\Command;

use Articles\Model\Model\ActiveUser;
use Articles\Model\Model\System;
use Articles\Model\Model\Webmaster;
use Articles\Service\TopicService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class AddTopicCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:addTopic")->addArgument("title", InputArgument::REQUIRED, "Title of the topic")
            ->addArgument("description", InputArgument::REQUIRED, "Description of the topic");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(empty(self::$user)){
            $output->writeln("You must be logged in to write an article.");
            return;
        }
        if(!(self::$user instanceof ActiveUser)){
            $output->writeln("You must be an active user to add a topic.");
            return;
        }
        $service = TopicService::getInstance($this->createSystem());
        $title = $input->getArgument("title");
        $description = $input->getArgument("description");
        $topic = $service->addTopic(self::$user, $title, $description);
        $output->writeln("The new topic has ID ".$topic->getId());
    }
}