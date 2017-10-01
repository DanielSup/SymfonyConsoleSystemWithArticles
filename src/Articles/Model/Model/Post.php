<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 24.9.17
 * Time: 14:27
 */
namespace Articles\Model\Model;

class Post extends Model
{
    use SerializableTrait;
    private $author;
    private $article;
    private $text;
    private $created;
    private $lastEdited;
    public function __construct(User $author, Article $article, $text)
    {
        parent::__construct();
        $this->author = $author;
        $this->article = $article;
        $this->text = $text;
        $this->created = new \DateTime();
        $this->lastEdited = $this->created;
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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getLastEdited()
    {
        return $this->lastEdited;
    }
    /**
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
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
    public function getCreated()
    {
        return $this->created;
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
        if(!empty($this->author) && !($this->author instanceof User)){
            $this->author = Model::find($this->author);
        }
        if(!empty($this->article) && !($this->article instanceof Article)){
            $this->article = Model::find($this->article);
        }
    }

}