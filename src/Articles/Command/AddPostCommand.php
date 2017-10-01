<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25.9.17
 * Time: 12:12
 */

namespace Articles\Command;

use Articles\Model\Exception\NoSuchArticleException;
use Articles\Model\Model\Article;
use Articles\Model\Model\System;
use Articles\Model\Model\Webmaster;
use Articles\Service\PostService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class AddPostCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:addPost")->addArgument("articleID", InputArgument::REQUIRED, "ID of the article.")
            ->addArgument("text", InputArgument::REQUIRED, "Text of the post");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(empty(self::$user)){
            $output->writeln("You must be logged in to write an article.");
            return;
        }
        $service = PostService::getInstance($this->createSystem());
        $article = null;
        try {
            $article = Article::find(intval($input->getArgument("articleID")));
        } catch(NoSuchArticleException $ex){
            $output->writeln("Article with ID ".$input->getArgument("articleID")." wasn't found.");
            return;
        }
        $text = $input->getArgument("text");
        $service->addPost(self::$user, $article, $text);
    }
}