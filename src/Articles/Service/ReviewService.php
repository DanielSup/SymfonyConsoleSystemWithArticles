<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25.9.17
 * Time: 12:09
 */

namespace Articles\Service;


use Articles\Model\Model\ActiveUser;
use Articles\Model\Model\Article;
use Articles\Model\Model\Review;
use Articles\Model\Model\User;

class ReviewService
{
    use SingletonTrait;
    public function getReviews(){
        return Review::walk();
    }
    public function getReviewOfTheAuthorToTheArticle(ActiveUser $author, Article $article){
        $reviewArray = array();
        $reviews = Review::walk();
        foreach ($reviews as $review){
            if($review->getAuthor() == $author && $review->getArticle() == $article){
                $reviewArray[$review->getId()] = $review;
            }
        }
        return $review;
    }
    public function addReview(Article $article, ActiveUser $author, $title, $text, $rating){
        $review = new Review($article, $author, $title, $text, $rating);
        $article->addReview($review);
        $author->addReview($review);
        $article->save();
        $author->save();
        $review->save();
        return $review;
    }
    public function removeReview(Review $review){
        $review->getAuthor()->removeReview($review);
        $review->getArticle()->removeReview($review);
        $review->getAuthor()->save();
        $review->getArticle()->save();
        $review->delete();
    }

    public function editTitleOfTheReview(Review $review, $title){
        $review->setTitle($title);
        $review->save();
    }

    public function editTextOfTheReview(Review $review, $text){
        $review->setTitle($text);
        $review->save();
    }
    public function editRating(Review $review, $rating){
        $review->setRating($rating);
        $review->save();
    }
}