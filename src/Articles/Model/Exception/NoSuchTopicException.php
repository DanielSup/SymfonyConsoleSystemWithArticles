<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.9.17
 * Time: 21:51
 */

namespace Articles\Model\Exception;


class NoSuchTopicException extends TopicException
{
    protected $id;
    private $previous;
    public function __construct($message = "", $code = 9, Exception $previous = null)
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