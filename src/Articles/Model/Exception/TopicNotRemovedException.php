<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.9.17
 * Time: 21:52
 */

namespace Articles\Model\Exception;


use Articles\Model\Model\Topic;

class TopicNotRemovedException extends TopicPersistenceException
{
    private $previous;
    private $topic;
    public function __construct($message = "", $code = 17, Exception $previous = null)
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