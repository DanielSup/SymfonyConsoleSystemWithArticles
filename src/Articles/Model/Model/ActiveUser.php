<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 24.9.17
 * Time: 14:30
 */
namespace Articles\Model\Model;

class ActiveUser extends User
{
    protected $reviews;
    protected $topics;
    public function __construct($email, $nickName)
    {
        parent::__construct($email, $nickName);
        $this->reviews = array();
        $this->topics = array();
    }
    public function addTopic(Topic $topic){
        $this->topics[$topic->getId()] = $topic;
    }
    public function removeTopic(Topic $topic){
        unset($this->topics[$topic->getId()]);
    }
    public function addReview(Review $review){
        $this->reviews[$review->getId()] = $review;
    }
    public function removeReview(Review $review){
        unset($this->reviews[$review->getId()]);
    }

    /**
     * @param array $reviews
     */
    public function setReviews($reviews)
    {
        $this->reviews = $reviews;
    }

    /**
     * @param array $topics
     */
    public function setTopics($topics)
    {
        $this->topics = $topics;
    }

    /**
     * @return array
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * @return array
     */
    public function getTopics()
    {
        return $this->topics;
    }
    public function preSerialize($properties)
    {
        if(!empty($properties["posts"])){
            $properties["posts"] = array_map(function($post){ return $post->getId();}, $properties["posts"]);
        }
        if(!empty($properties["reviews"])){
            $properties["reviews"] = array_map(function($review){ return $review->getId();}, $properties["review"]);
        }
        if(!empty($properties["topics"])){
            $properties["topics"] = array_map(function($topic){ return $topic->getId();}, $properties["topics"]);
        }
        return $properties;
    }
    public function postUnserialize()
    {
        parent::postUnserialize();
        if(!empty($this->reviews)){
            $this->reviews = array_map(function($review){
                                        return $review instanceof Review ? $review : Model::find($review);}
                                        , $this->reviews);
        }
        if(!empty($this->topics)){
            $this->topics = array_map(function($topic){
                                    return $topic instanceof Topic ? $topic : Model::find($topic);}, $this->topics);
        }
    }

}