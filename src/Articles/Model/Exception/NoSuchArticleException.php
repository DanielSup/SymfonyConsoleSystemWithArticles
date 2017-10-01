<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.9.17
 * Time: 21:44
 */

namespace Articles\Model\Exception;


class NoSuchArticleException extends ArticleException
{
    protected $id;
    private $previous;
    public function __construct($message = "", $code = 6, Exception $previous = null)
    {
        parent::__construct($message, $code);
        $this->previous = $previous;
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}