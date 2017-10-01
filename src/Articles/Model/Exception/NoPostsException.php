<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.9.17
 * Time: 21:48
 */

namespace Articles\Model\Exception;


class NoPostsException extends PostException
{
    private $previous;
    public function __construct($message = "", $code = 4, Exception $previous = null)
    {
        parent::__construct($message, $code);
        $this->previous = $previous;
    }
}