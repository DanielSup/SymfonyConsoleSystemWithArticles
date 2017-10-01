<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.9.17
 * Time: 21:44
 */

namespace Articles\Model\Exception;


use Articles\Model\Model\Article;

class ArticleNotSavedException extends ArticlePersistenceException
{
    protected $article;
    private $previous;
    public function __construct($message = "", $code = 2, Exception $previous = null)
    {
        parent::__construct($message, $code);
        $this->previous = $previous;
    }

    /**
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param Article $article
     */
    public function setArticle(Article $article)
    {
        $this->article = $article;
    }
}