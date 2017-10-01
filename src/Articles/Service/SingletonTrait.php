<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 28.9.17
 * Time: 14:25
 */

namespace Articles\Service;

use Articles\Model\Model\System;

trait SingletonTrait
{
    protected $system;
    protected static $instance;
    protected function __construct(System $system){
        $this->system = $system;
    }
    public static function getInstance($system){
        if(empty(static::$instance)){
            static::$instance = new static($system);
        }
        return static::$instance;
    }

    /**
     * @return mixed
     *
     */
    public function getSystem()
    {
        return $this->system;
    }

    /**
     * @param mixed $system
     */
    public function setSystem($system)
    {
        $this->system = $system;
    }
}