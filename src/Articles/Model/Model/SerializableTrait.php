<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27.9.17
 * Time: 13:43
 */

namespace Articles\Model\Model;


trait SerializableTrait
{
    public function serialize(){
        $properties = get_object_vars($this);
        $this->preSerialize($properties);
        $properties["_parent"] = parent::serialize();
        return serialize($properties);
    }
    public function unserialize($serialized){
        $properties = unserialize($serialized);
        parent::unserialize($properties["_parent"]);
        foreach ($properties as $property => $value){
            $this->$property = $value;
        }
    }
}