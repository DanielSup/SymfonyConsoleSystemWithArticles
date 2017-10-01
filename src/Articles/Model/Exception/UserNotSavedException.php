<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.9.17
 * Time: 21:54
 */

namespace Articles\Model\Exception;


class UserNotSavedException extends UserPersistenceException
{
    private $previous;
    protected $user;
    public function __construct($message = "", $code = 20, Exception $previous = null)
    {
        parent::__construct($message, $code);
        $this->previous = $previous;
    }

    /**
     * @param mixed $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }
}