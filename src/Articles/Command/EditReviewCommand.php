<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30.9.17
 * Time: 9:22
 */

namespace Articles\Command;

use Articles\Model\Exception\NoSuchReviewException;
use Articles\Model\Model\ActiveUser;
use Articles\Model\Model\Review;
use Articles\Model\Model\System;
use Articles\Model\Model\Webmaster;
use Articles\Service\ReviewService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EditReviewCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:editReview")->addArgument("reviewID", InputArgument::REQUIRED, "ID of the review")->
        addArgument("title", InputArgument::OPTIONAL, "Title of the review")->
        addArgument("text", InputArgument::OPTIONAL, "Text of the review")->
        addArgument("rating", InputArgument::OPTIONAL, "Rating of the review. (non double value = 0.0)");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(empty(self::$user)){
            $output->writeln("You must be logged in to edit a review");
            return;
        }
        if(!(self::$user instanceof ActiveUser)){
            $output->writeln("You must be an active user to edit a review");
            return;
        }
        $review = null;
        try{
            $id = intval($input->getArgument("reviewID"));
            $review = Review::find($id);
        } catch (NoSuchReviewException $ex){
            $output->writeln("Review with ID ".$input->getArgument("reviewID")." wasn't found.");
            return;
        }
        $service = ReviewService::getInstance($this->createSystem());
        if(!empty($input->getArgument("title"))){
            $title = $input->getArgument("title");
            $service->editTitleOfTheReview($review, $title);
        }
        if(!empty($input->getArgument("text"))){
            $text = $input->getArgument("text");
            $service->editTextOfTheReview($review, $text);
        }
        if(!empty($input->getArgument("rating"))){
            $rating = doubleval($input->getArgument("rating"));
            $service->editRatingOfTheReview($review, $rating);
        }
    }
}