<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 30.9.17
 * Time: 16:54
 */
namespace Articles\Service;

use Articles\Command\LogInCommand;
use Articles\Model\Exception\NoSuchUserException;
use Articles\Model\Model\User;

class UserService
{
    use SingletonTrait;
    public static $file = "./log.txt";
    protected static $delimiter=";";
    public function getUsers(){
        return User::walk();
    }
    public function addUser($email, $nickName){
        $user = new User($email, $nickName);
        $this->system->registerUser($email, $nickName);
        $user->save();
    }
    public function banUser(User $user){
        $this->system->getWebmaster()->banUser($user);
        $this->system->banUser($user);
    }
    public function logUser($id, $type = "u"){
        file_put_contents(self::$file, $id.self::$delimiter.$type);
    }
    public function getLoggedUser(){
        if(!file_exists(self::$file)){
            return null;
        }
        $idAndType = file_get_contents(self::$file);
        $exploded = explode(self::$delimiter, $idAndType);
        $id = $exploded[0];
        $type = "Articles\\Model\\Model\\".LogInCommand::$array[trim($exploded[1])];
        return $type::find(intval($id));
    }
}