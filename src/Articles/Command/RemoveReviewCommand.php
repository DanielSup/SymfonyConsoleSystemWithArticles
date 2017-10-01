<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25.9.17
 * Time: 12:13
 */

namespace Articles\Command;

use Articles\Model\Exception\NoSuchReviewException;
use Articles\Model\Model\ActiveUser;
use Articles\Model\Model\Review;
use Articles\Service\ReviewService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveReviewCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:removeReview")->addArgument("reviewID", InputArgument::REQUIRED, "ID of the review");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(empty(self::$user)){
            $output->writeln("You must be logged in to remove a review.");
            return;
        }
        if(!(self::$user instanceof ActiveUser)){
            $output->writeln("You must be an active user to remove a review.");
            return;
        }
        $service = ReviewService::getInstance($this->createSystem());
        $id = intval($input->getArgument("reviewID"));
        try {
            $review = Review::find($id);
            $service->removeReview($review);
        } catch(NoSuchReviewException $ex){
            $output->writeln("Review with ID ".$input->getArgument("reviewID")." wasn't found.");
        }
    }
}