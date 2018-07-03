<?php
/**
 * 基类
 * User: xiafan
 * Date: 2016/12/14
 * Time: 10:31
 */

namespace Common\Common;

class Base {

    public function to_array() {
        $ref = new \ReflectionClass($this);
        $to_array = array();
        $properties = $ref->getProperties();

        foreach ($properties as &$property) {
            $to_array[$property->getName()] = $this->{$property->getName()};
        }
        return $to_array;
    }

    public function get_property_value($property_name) {
        $ref = new \ReflectionClass($this);
        return $this->{$property_name};
    }
}
