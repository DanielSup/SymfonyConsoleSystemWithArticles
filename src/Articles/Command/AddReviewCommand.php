<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25.9.17
 * Time: 12:12
 */

namespace Articles\Command;

use Articles\Model\Exception\NoSuchArticleException;
use Articles\Model\Model\ActiveUser;
use Articles\Model\Model\Article;
use Articles\Model\Model\System;
use Articles\Model\Model\Webmaster;
use Articles\Service\ReviewService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class AddReviewCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:addReview")->addArgument("articleID", InputArgument::REQUIRED, "ID of the article.")
            ->addArgument("title", InputArgument::REQUIRED, "Title of the review")
            ->addArgument("text", InputArgument::REQUIRED, "Text of the review")
            ->addArgument("rating", InputArgument::REQUIRED, "Rating of the article.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(empty(self::$user)){
            $output->writeln("You must be logged in to write an article.");
            return;
        }
        if(!(self::$user instanceof ActiveUser)){
            $output->writeln("You must be an active user to write a review.");
            return;
        }
        $service = ReviewService::getInstance($this->createSystem());
        $article = null;
        try {
            $article = Article::find(intval($input->getArgument("articleID")));
        } catch(NoSuchArticleException $ex){
            $output->writeln("Article with ID ".$input->getArgument("articleID")." wasn't found.");
            return;
        }
        $title = $input->getArgument("title");
        $text = $input->getArgument("text");
        $rating = doubleval($input->getArgument("rating"));
        $service->addReview($article,self::$user, $title, $text, $rating);
    }
}