<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.9.17
 * Time: 21:51
 */

namespace Articles\Model\Exception;


class NoTopicsException extends TopicException
{
    private $previous;
    public function __construct($message = "", $code = 11, Exception $previous = null)
    {
        parent::__construct($message, $code);
        $this->previous = $previous;
    }
}