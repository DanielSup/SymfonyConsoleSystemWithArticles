<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30.9.17
 * Time: 9:21
 */

namespace Articles\Command;

use Articles\Model\Exception\NoSuchTopicException;
use Articles\Model\Model\System;
use Articles\Model\Model\Topic;
use Articles\Model\Model\Webmaster;
use Articles\Service\TopicService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EditTopicCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:editTopic")->addArgument("topicID", InputArgument::REQUIRED, "ID of the topic")
        ->addArgument("title", InputArgument::OPTIONAL, "Title of the topic")
            ->addArgument("text", InputArgument::OPTIONAL, "Text of the topic");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(empty(self::$user)){
            $output->writeln("You must be logged in to edit a review");
            return;
        }
        if(!(self::$user instanceof ActiveUser)){
            $output->writeln("You must be an active user to edit a review");
            return;
        }
        $topic = null;
        try {
            $id = intval($input->getArgument("topicID"));
            $topic = Topic::find($id);
        } catch(NoSuchTopicException $ex){
            $output->writeln("Topic with ID ".$input->getArgument("topicID")." wasn't found.");
            return;
        }
        $service = TopicService::getInstance($this->createSystem());
        if(!empty($input->getArgument("title"))){
            $title = $input->getArgument("title");
            $service->editTitleOfTheTopic($title);
        }
        if(!empty($input->getArgument("text"))){
            $text = $input->getArgument("text");
            $service->editTitleOfTheTopic($text);
        }
    }
}