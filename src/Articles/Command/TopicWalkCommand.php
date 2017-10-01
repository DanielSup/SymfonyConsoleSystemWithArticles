<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30.9.17
 * Time: 16:27
 */

namespace Articles\Command;

use Articles\Service\TopicService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TopicWalkCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:topicWalk");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $service = TopicService::getInstance($this->createSystem());
        $topics = $service->getTopics();
        foreach ($topics as $topic){
            $output->writeln($topic->getId());
            $output->writeln("Author: ".$topic->getAuthor()->getId());
            $output->writeln($topic->getTitle());
            $output->writeln($topic->getDescription());
        }
    }
}