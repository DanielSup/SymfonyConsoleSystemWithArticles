<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30.9.17
 * Time: 16:27
 */

namespace Articles\Command;

use Articles\Service\ReviewService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReviewWalkCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:reviewWalk");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $service = ReviewService::getInstance($this->createSystem());
        $reviews = $service->getReviews();
        foreach ($reviews as $review){
            $output->writeln($review->getId());
            $output->writeln("Article: ".$review->getArticle()->getId());
            $output->writeln("Author: ".$review->getAuthor()->getId());
            $output->writeln($review->getTitle());
            $output->writeln($review->getText());
            $output->writeln($review->getRating());
        }
    }
}