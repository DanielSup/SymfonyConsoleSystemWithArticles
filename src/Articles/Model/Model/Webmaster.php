<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 24.9.17
 * Time: 14:31
 */
namespace Articles\Model\Model;

use League\Flysystem\Exception;

class Webmaster extends Administrator
{
    public $system;
    public function __construct($email, $nickName)
    {
        parent::__construct($email, $nickName);
    }
    public function banUser(User $user){
        if(empty($this->system)){
            throw new Exception("null system.");
        }
        if($user instanceof Administrator){
            throw new \Exception();
        }
        $this->system->banUser($user);
    }
}