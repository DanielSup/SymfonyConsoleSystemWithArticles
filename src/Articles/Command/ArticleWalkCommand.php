<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30.9.17
 * Time: 16:26
 */

namespace Articles\Command;

use Articles\Model\Exception\NoArticlesException;
use Articles\Model\Model\Article;
use Articles\Model\Model\System;
use Articles\Model\Model\Webmaster;
use Articles\Service\ArticleService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ArticleWalkCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:articleWalk");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $service = ArticleService::getInstance($this->createSystem());
        try {
            $articles = $service->getArticles();
        } catch(NoArticlesException $ex){
            $output->writeln("No articles.");
            return;
        }
        foreach ($articles as $article){
            $output->writeln($article->getId());
            $output->writeln("Author: ".$article->getAuthor()->getId());
            $output->writeln($article->getTitle());
            $output->writeln($article->getText());
        }
    }
}