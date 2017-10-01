<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25.9.17
 * Time: 12:12
 */

namespace Articles\Command;

use Articles\Model\Exception\NoSuchTopicException;
use Articles\Model\Model\ActiveUser;
use Articles\Model\Model\Topic;
use Articles\Service\TopicService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveTopicCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:removeTopic")->addArgument("topicID", InputArgument::REQUIRED, "ID of the topic");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (empty(self::$user)) {
            $output->writeln("You must be logged in to remove a topic.");
            return;
        }
        if (!(self::$user instanceof ActiveUser)) {
            $output->writeln("You must be an active user to remove a topic.");
            return;
        }
        $service = TopicService::getInstance($this->createSystem());
        $id = intval($input->getArgument("topicID"));
        try {
            $topic = Topic::find($id);
            $service->removeTopic($topic);
        } catch (NoSuchTopicException $ex) {
            $output->writeln("Topic with ID " . $input->getArgument("topicID") . " wasn't found.");
        }
    }
}