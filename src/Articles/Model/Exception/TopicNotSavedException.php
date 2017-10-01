<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.9.17
 * Time: 21:52
 */

namespace Articles\Model\Exception;


class TopicNotSavedException extends TopicPersistenceException
{
    private $previous;
    private $topic;
    public function __construct($message = "", $code = 18, Exception $previous = null)
    {
        parent::__construct($message, $code);
        $this->previous = $previous;
    }

    /**
     * @return mixed
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param mixed $topic
     */
    public function setTopic(Topic $topic)
    {
        $this->topic = $topic;
    }
}