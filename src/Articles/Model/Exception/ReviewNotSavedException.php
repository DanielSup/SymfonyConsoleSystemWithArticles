<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.9.17
 * Time: 21:50
 */

namespace Articles\Model\Exception;


class ReviewNotSavedException extends ReviewPersistenceException
{
    private $previous;
    private $review;
    public function __construct($message = "", $code = 16, Exception $previous = null)
    {
        parent::__construct($message, $code);
        $this->previous = $previous;
    }

    /**
     * @return mixed
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * @param mixed $review
     */
    public function setReview(Review $review)
    {
        $this->review = $review;
    }
}