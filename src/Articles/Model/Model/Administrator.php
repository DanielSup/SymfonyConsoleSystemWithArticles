<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 24.9.17
 * Time: 14:26
 */

namespace Articles\Model\Model;


class Administrator extends ActiveUser
{
    public function blockUser(User $user){
        if($user instanceof Administrator){
            throw new \Exception();
        }
        $user->setBlocked(true);
    }
}