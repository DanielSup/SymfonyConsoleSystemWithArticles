<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27.9.17
 * Time: 13:38
 */

namespace Articles\Model\Model;

use Articles\Service\StorageService;
use League\Flysystem\Exception;

abstract class Model implements \Serializable
{
    static $lastID=0;
    static $models = array();
    protected $id;
    protected static $exceptionNamespace="Articles\\Model\\Exception\\";

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }
    public function __construct()
    {
        $this->id = static::$lastID;
        static::$lastID++;
    }
    public function save(){
        if(empty($this->id)){
            $this->id = $this->nextId();
        }
        try {
            $filesystem = StorageService::getInstance()->getFilesystem();
            $filesystem->put(static::getShortName() . "/" . $this->id . ".ser", serialize($this));
            static::$models[static::getShortName() . $this->id] = $this;
        } catch(\Exception $ex){
            $object = $this;
            $className = self::$exceptionNamespace.static::getShortNameForException()."NotSavedException";
            $exception = new $className();
            $methodName = "set".$object;
            $exception->$methodName($object);
            throw $exception;
        }
    }
    public function delete(){
        try {
            $filesystem = StorageService::getInstance()->getFilesystem();
            $filesystem->delete(static::getShortName() . "/" . $this->id . ".ser");
            unset(static::$models[static::getShortName() . $this->id]);
        } catch(\Exception $ex){
            $object = $this;
            $className = self::$exceptionNamespace.static::getShortNameForException()."NotRemovedException";
            $exception = new $className();
            $methodName = "set".$object;
            $exception->$methodName($object);
            throw $exception;
        }
    }
    public static function find($id){
        if(isset($models[static::getShortName().$id])){
            return $models[static::getShortName().$id];
        }
        try{
            $filesystem = StorageService::getInstance()->getFilesystem();
            $object = unserialize($filesystem->read(static::getShortName()."/".$id.".ser"));
            static::$models[static::getShortName().$object->getId()] = $object;
            $object->postUnserialize();
            return $object;
        } catch (\Exception $ex){
            $className = self::$exceptionNamespace."NoSuch".static::getShortNameForException()."Exception";
            $exception = new $className();
            throw $exception;
        }
    }
    public static function getShortName(){
        return (new \ReflectionClass(static::class))
            ->getShortName();
    }
    public static function getShortNameForException(){
        $array = array("ActiveUser", "Administrator", "Webmaster");
        $name = (new \ReflectionClass(static::class))
            ->getShortName();
        if(in_array($name, $array)){
            return "User";
        }
        return $name;
    }
    protected function nextId(){
        $filesystem = StorageService::getInstance()->getFilesystem();
        $id = 0;
        foreach ($filesystem->listContents(static::getShortName()) as $file){
            if($id < $file['filename']){
                $id = $file['filename'];
            }
        }
        return $id+1;
    }
    public static function walk(){
        $array = array();
        try{
            $filesystem = StorageService::getInstance()->getFilesystem();
            foreach ($filesystem->listContents(static::getShortName()) as $file) {
                if ($file["type"] == "file") {
                    $object = static::find($file["filename"]);
                    if ($object instanceof static) {
                        $array[$object->getId()] = $object;
                    }
                }
            }
            return $array;
        } catch(\Exception $ex){
            $className = self::$exceptionNamespace."No".static::getShortNameForException()."sException";
            $exception = new $className();
            throw $exception;
        }
    }
    protected function preSerialize($properties){
        return $properties;
    }
    protected function postUnserialize(){
    }
    public function serialize()
    {
        return;
    }
    public function unserialize($serialized)
    {
    }
}