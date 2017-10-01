<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24.9.17
 * Time: 16:28
 */

namespace Articles\Model\Model;


use Articles\Model\Exception\NoSuchUserException;
use League\Flysystem\Exception;

class System
{
    private $webmaster;
    private $users;
    private $topics;
    private static $instance = null;
    private function __construct(Webmaster $webmaster){
        $this->webmaster = $webmaster;
        $this->users = array();
        $this->users[$this->webmaster->getEmail()] = $webmaster;
        try{
            Webmaster::find($webmaster->getId());
        } catch (NoSuchUserException $ex) {
            $webmaster->save();
        }
        $this->topics = array();
    }
    public static function getInstance(Webmaster $webmaster){
        if(self::$instance == null){
            self::$instance = new System($webmaster);
        }
        return self::$instance;
    }
    public function registerUser(User $user){
        $this->users[$user->getEmail()] = $user;
        $user->save();
    }
    public function banUser(User $user){
        unset($this->users[$user->getEmail()]);
        $user->delete();
    }
    public function addTopic(Topic $topic){
        $this->topics[$topic->getId()] = $topic;
    }
    public function removeTopic(Topic $topic){
        unset($this->topics[$topic->getId()]);
    }

    /**
     * @return array
     */
    public function getTopics()
    {
        return $this->topics;
    }

    /**
     * @return array
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @return Webmaster
     */
    public function getWebmaster()
    {
        return $this->webmaster;
    }
}