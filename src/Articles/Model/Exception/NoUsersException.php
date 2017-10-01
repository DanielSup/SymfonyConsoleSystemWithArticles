<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.9.17
 * Time: 21:53
 */

namespace Articles\Model\Exception;


class NoUsersException extends UserException
{
    private $previous;
    public function __construct($message = "", $code = 12, Exception $previous = null)
    {
        parent::__construct($message, $code);
        $this->previous = $previous;
    }
}