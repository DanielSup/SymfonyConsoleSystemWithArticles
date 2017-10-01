<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30.9.17
 * Time: 9:21
 */

namespace Articles\Command;

use Articles\Model\Exception\NoSuchArticleException;
use Articles\Model\Exception\NoSuchTopicException;
use Articles\Model\Model\Article;
use Articles\Model\Model\System;
use Articles\Model\Model\Topic;
use Articles\Model\Model\Webmaster;
use Articles\Service\ArticleService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EditArticleCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:editArticle")->addArgument("articleID", InputArgument::REQUIRED, "ID of the article")
            ->addArgument("text", InputArgument::OPTIONAL, "Text of the article")
            ->addArgument("title", InputArgument::OPTIONAL, "Title of the article")
            ->addArgument("topicID", InputArgument::OPTIONAL, "ID of the topic");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(empty(self::$user)){
            $output->writeln("You must be logged in to edit an article");
            return;
        }
        $service = ArticleService::getInstance($this->createSystem());
        $id = intval($input->getArgument("articleID"));
        $article = null;
        try {
            $article = Article::find($id);
        } catch(NoSuchArticleException $ex){
            $output->writeln("Article with ID ".$input->getArgument("articleID")." wasn't found.");
            return;
        }
        if(!empty($input->getArgument("text"))){
            $text = $input->getArgument("text");
            $service->editTextOfTheArticle($article, $text);
        }
        if(!empty($input->getArgument("title"))){
            $title = $input->getArgument("title");
            $service->editTitleOfTheArticle($article, $title);
        }
        if(!empty($input->getArgument("topicID"))){
            $topic = null;
            $id = intval($input->getArgument("topicID"));
            try {
                $topic = Topic::find($id);
            } catch(NoSuchTopicException $ex){
                $output->writeln("Topic with ID ".$input->getArgument("topicID")." wasn't found.");
                return;
            }
            $service->editTopicOfTheArticle($article, $topic);
        }
    }
}