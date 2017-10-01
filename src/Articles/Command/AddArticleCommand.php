<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25.9.17
 * Time: 12:11
 */

namespace Articles\Command;

use Articles\Model\Exception\NoSuchTopicException;
use Articles\Model\Model\Topic;
use Articles\Model\Model\Webmaster;
use Articles\Service\ArticleService;
use Articles\Model\Model\System;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddArticleCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:addArticle")->addArgument("topicID", InputArgument::REQUIRED, "ID of the topic.")->
        addArgument("title", InputArgument::REQUIRED, "Title of the article.")->
        addArgument("text", InputArgument::REQUIRED, "Text of the article");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(empty(self::$user)){
            $output->writeln("You must be logged in to write an article.");
            return;
        }
        $service = ArticleService::getInstance($this->createSystem());
        $topic = null;
        try {
            $topic = Topic::find(intval($input->getArgument("topicID")));
        } catch(NoSuchTopicException $ex){
            $output->writeln("Topic with ID ".$input->getArgument("topicID")." wasn't found.");
            return;
        }
        $title = $input->getArgument("title");
        $text = $input->getArgument("text");
        $article = $service->addArticle($topic, self::$user, $title, $text);
        $output->writeln("The new article has ID ".$article->getId());
    }
}