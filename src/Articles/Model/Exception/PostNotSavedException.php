<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.9.17
 * Time: 21:48
 */

namespace Articles\Model\Exception;


class PostNotSavedException extends PostPersistenceException
{
    private $previous;
    protected $post;
    public function __construct($message = "", $code = 14, Exception $previous = null)
    {
        parent::__construct($message, $code);
        $this->previous = $previous;
    }

    /**
     * @param mixed $post
     */
    public function setPost(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }
}