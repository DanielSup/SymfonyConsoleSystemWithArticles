<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.9.17
 * Time: 21:49
 */

namespace Articles\Model\Exception;


use Articles\Model\Model\Post;

class PostNotRemovedException extends PostPersistenceException
{
    private $previous;
    private $post;
    public function __construct($message = "", $code = 13, Exception $previous = null)
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