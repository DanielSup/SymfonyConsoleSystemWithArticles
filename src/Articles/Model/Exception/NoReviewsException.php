<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.9.17
 * Time: 21:49
 */

namespace Articles\Model\Exception;


class NoReviewsException extends ReviewException
{
    private $previous;
    public function __construct($message = "", $code = 5, Exception $previous = null)
    {
        parent::__construct($message, $code);
        $this->previous = $previous;
    }
}