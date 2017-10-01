<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 24.9.17
 * Time: 14:25
 */
namespace Articles\Model\Model;

class Article extends Model
{
    use SerializableTrait;
    private $topic;
    private $author;
    private $title;
    private $text;
    private $posts;
    private $reviews;
    private $created;
    private $lastEdited;
    public function __construct(Topic $topic, User $author, $title, $text)
    {
        parent::__construct();
        $this->topic = $topic;
        $this->author = $author;
        $this->title = $title;
        $this->text = $text;
        $this->posts = array();
        $this->reviews = array();
        $this->created = new \DateTime();
        $this->lastEdited = $this->created;
    }

    public function addPost(Post $post){
        $this->posts[$post->getId()] = $post;
    }
    public function removePost(Post $post){
        unset($this->posts[$post->getId()]);
    }
    public function addReview(Review $review){
        $this->reviews[$review->getId()] = $review;
    }
    public function removeReview(Review $review){
        unset($this->reviews[$review->getId()]);
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLastEdited()
    {
        return $this->lastEdited;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
        $this->lastEdited = new \DateTime();
    }

    /**
     * @return array
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @return array
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return Topic
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->lastEdited = new \DateTime();
    }

    /**
     * @param Topic $topic
     */
    public function setTopic(Topic $topic)
    {
        $this->topic = $topic;
        $this->lastEdited = new \DateTime();
    }

    public function preSerialize($properties)
    {
        if(!empty($properties["author"])){
            $properties["author"] = $properties["author"]->getId();
        }
        if(!empty($properties["topic"])){
            $properties["topic"] = $properties["topic"]->getId();
        }
        if(!empty($properties["posts"])){
            $properties["posts"] = array_map(function($review){ return $review->getId();}, $properties["posts"]);
        }
        if(!empty($properties["reviews"])){
            $properties["reviews"] = array_map(function($review){ return $review->getId();}, $properties["reviews"]);
        }
        return $properties;
    }
    public function postUnserialize()
    {
        parent::postUnserialize();
        if(!empty($this->author) && !($this->author instanceof User)){
            $this->author = Model::find($this->author);
        }
        if(!empty($this->topic) && !($this->topic instanceof Topic)){
            $this->topic = Model::find($this->topic);
        }
        if(!empty($this->posts)){
            $this->posts = array_map(function($post){ return $post instanceof Post ? $post : Model::find($post);}, $this->posts);
        }
        if(!empty($this->reviews)){
            $this->reviews = array_map(function($review){ return $review instanceof Review ? $review : Model::find($review);}, $this->reviews);
        }
    }
}