<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.9.17
 * Time: 21:46
 */

namespace Articles\Model\Exception;


class NoArticlesException extends ArticleException
{
    private $previous;
    public function __construct($message = "", $code = 3, Exception $previous = null)
    {
        parent::__construct($message, $code);
        $this->previous = $previous;
    }
}