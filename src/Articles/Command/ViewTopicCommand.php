<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25.9.17
 * Time: 12:13
 */

namespace Articles\Command;

use Articles\Model\Exception\NoSuchTopicException;
use Articles\Model\Model\Topic;
use Articles\Service\TopicService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ViewTopicCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:viewTopic")->addArgument("topicID", InputArgument::REQUIRED, "ID of the topic");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $id = intval($input->getArgument("topicID"));
            $topic = Topic::find($id);
            $output->writeln("ID: ".$topic->getId());
            $output->writeln("Author: ".$topic->getAuthor()->getNickName());
            $output->writeln("Title: ".$topic->getTitle());
            $output->writeln("Description: ".$topic->getDescription());
            $articles = $topic->getArticles();
            foreach ($articles as $article){
                $output->writeln("ID: ".$article->getId());
                $output->writeln("Author: ".$article->getAuthor()->getNickName());
                $output->writeln("Topic: ".$article->getTopic()->getTitle());
                $output->writeln("Title: ".$article->getTitle());
                $output->writeln("Text: ".$article->getText());
            }
        } catch (NoSuchTopicException $ex){
            $output->writeln("Topic with ID ".$input->getArgument("topicID")." wasn't be found.");
        }
    }
}