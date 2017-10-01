<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25.9.17
 * Time: 12:13
 */

namespace Articles\Command;

use Articles\Model\Exception\NoSuchArticleException;
use Articles\Model\Model\Article;
use Articles\Service\PostService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ViewArticleCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:viewArticle")->addArgument("articleID", InputArgument::REQUIRED, "ID of the article");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $id = intval($input->getArgument("articleID"));
            $article = Article::find($id);
            $output->writeln("ID: ".$article->getId());
            $output->writeln("Author: ".$article->getAuthor()->getNickName());
            $output->writeln("Topic: ".$article->getTopic()->getTitle());
            $output->writeln("Title: ".$article->getTitle());
            $output->writeln("Text: ".$article->getText());
            $posts = $article->getPosts();
            $reviews = $article->getReviews();
            foreach ($posts as $post){
                $output->writeln($post->getId());
                $output->writeln("Author: ".$post->getAuthor()->getNickName());
                $output->writeln($post->getText());
            }
            foreach ($reviews as $review){
                $output->writeln($review->getId());
                $output->writeln("Author: ".$review->getAuthor()->getNickName());
                $output->writeln($review->getTitle());
                $output->writeln($review->getText());
                $output->writeln($review->getRating());
            }
        } catch (NoSuchArticleException $ex){
            $output->writeln("Article with ID ".$input->getArgument("articleID")." wasn't found.");
        }
    }
}