<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 24.9.17
 * Time: 14:27
 */
namespace Articles\Model\Model;

class Topic extends Model
{
    use SerializableTrait;
    private $title;
    private $description;
    private $author;
    private $created;
    private $lastEdited;
    private $articles;

    public function __construct(ActiveUser $author, $title, $description)
    {
        parent::__construct();
        $this->author = $author;
        $this->title = $title;
        $this->description = $description;
        $this->created = new \DateTime();
        $this->lastEdited = $this->created;
        $this->articles = array();
    }

    public function addArticle(Article $article){
        $this->articles[$article->getId()] = $article;
    }
    public function removeArticle(Article $article){
        unset($this->articles[$article->getId()]);
    }
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        $this->lastEdited = new \DateTime();
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
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
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

    public function preSerialize($properties)
    {
        if(!empty($properties["author"])){
            $properties["author"] = $properties["author"]->getId();
        }
        if(!empty($properties["articles"])){
            $properties["articles"] = array_map(function($articles){ return $articles->getId();}, $properties["articles"]);
        }
        return $properties;
    }
    public function postUnserialize()
    {
        parent::postUnserialize();
        if(!empty($this->author) && !($this->author instanceof ActiveUser)){
            $this->author = Model::find($this->author);
        }
        if(!empty($this->articles)){
            $this->articles = array_map(function($article){ return $article instanceof Article ? $article : Model::find($article);}, $this->articles);
        }
    }
}