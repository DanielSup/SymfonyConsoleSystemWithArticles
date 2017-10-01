<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 24.9.17
 * Time: 14:25
 */
namespace Articles\Model\Model;

class User extends Model
{
    use SerializableTrait;
    protected $email;
    protected $nickName;
    protected $posts;
    protected $articles;
    protected $blocked;
    public function __construct($email, $nickName)
    {
        parent::__construct();
        $this->email = $email;
        $this->nickName = $nickName;
        $this->posts = array();
        $this->articles = array();
        $this->blocked = false;
    }

    /**
     * @return array
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param array $articles
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;
    }
    /**
     * @param boolean $blocked
     */
    public function setBlocked($blocked)
    {
        $this->blocked = $blocked;
    }
    public function addPost(Post $post){
        $this->posts[$post->getId()] = $post;
    }
    public function removePost(Post $post){
        $post->getArticle()->removePost($post);
        unset($this->posts[$post->getId()]);
    }
    public function updateTextOfPost(Post $post, $text){
        $this->posts[$post->getId()]->setText($text);
    }

    public function addArticle(Article $article){
        $this->articles[$article->getId()] = $article;
    }
    public function removeArticle(Article $article){
        unset($this->articles[$article->getId()]);
    }
    /**
     * @return boolean
     */
    public function isBlocked()
    {
        return $this->blocked;
    }

    /**
     * @param array $posts
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }
    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @return mixed
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    public function preSerialize($properties)
    {
        if(!empty($properties["posts"])){
            $properties["posts"] = array_map(function($post){ return $post->getId();}, $properties["posts"]);
        }
        if(!empty($properties["articles"])){
            $properties["articles"] = array_map(function($article){ return $article->getId();}, $properties["articles"]);
        }
        return $properties;
    }
    public function postUnserialize()
    {
        parent::postUnserialize();
        if(!empty($this->posts)){
            $this->posts = array_map(function($post){ return $post instanceof Post ? $post : Model::find($post);}, $this->posts);
        }
        if(!empty($this->articles)){
            $this->articles = array_map(function($article){ return $article instanceof Article ? $article : Model::find($article);}, $this->articles);
        }
    }

}