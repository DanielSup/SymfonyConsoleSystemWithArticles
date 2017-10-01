<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 24.9.17
 * Time: 14:29
 */
namespace Articles\Model\Model;


class Review extends Model
{
    use SerializableTrait;
    private $article;
    private $author;
    private $title;
    private $text;
    private $rating;
    private $created;
    private $lastEdited;
    public function __construct(Article $article, ActiveUser $author, $title, $text, $rating)
    {
        parent::__construct();
        $this->article = $article;
        $this->author = $author;
        $this->title = $title;
        $this->text = $text;
        $this->rating = $rating;
        $this->created = \DateTime();
        $this->lastEdited = $this->created;
    }

    /**
     * @return ActiveUser
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
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
    public function getRating()
    {
        return $this->rating;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
        $this->lastEdited = \DateTime();
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
        $this->lastEdited = \DateTime();
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->lastEdited = \DateTime();
    }
    public function preSerialize($properties)
    {
        if(!empty($properties["author"])){
            $properties["author"] = $properties["author"]->getId();
        }
        if(!empty($properties["article"])){
            $properties["article"] = $properties["article"]->getId();
        }
        return $properties;
    }
    public function postUnserialize()
    {
        parent::postUnserialize();
        if(!empty($this->author) && !($this->author instanceof ActiveUser)){
            $this->author = Model::find($this->author);
        }
        if(!empty($this->article) && !($this->article instanceof Article)){
            $this->article = Model::find($this->article);
        }
    }
}