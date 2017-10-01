<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25.9.17
 * Time: 12:13
 */

namespace Articles\Command;

use Articles\Model\Exception\NoSuchArticleException;
use Articles\Model\Model\ActiveUser;
use Articles\Model\Model\Article;
use Articles\Service\ArticleService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveArticleCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:removeArticle")->addArgument("articleID", InputArgument::REQUIRED, "ID of the article to remove.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(empty(self::$user)){
            $output->writeln("You must be logged in to remove an article.");
            return;
        }
        if(!(self::$user instanceof ActiveUser)){
            $output->writeln("You must be an active user in to remove an article.");
            return;
        }
        $service = ArticleService::getInstance($this->createSystem());
        $id = intval($input->getArgument("articleID"));
        try{
            $article = Article::find($id);
            $service->removeArticle($article);
        } catch(NoSuchArticleException $ex){
            $output->writeln("Article with ID ".$input->getArgument("articleID")." wasn't found");
        }
    }
}