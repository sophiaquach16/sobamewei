<?php

namespace App\Classes;

class IdentityMap {

    private $map;

    function _construct() {
        $this->map = array();
    }

    function add($objectClass, $object) {
        if (isset($this->map[$objectClass])) {
            array_push($this->map[$objectClass], $object);
        } else {
            $this->map[$objectClass] = array();
            array_push($this->map[$objectClass], $object);
        }
    }

    function delete($objectClass, $objectProperty, $objectPropertyValue) {
        if (isset($this->map[$objectClass])) {
            foreach ($this->map[$objectClass] as $key => $value) {
                if ($this->map[$objectClass][$key]->get()->$objectProperty === $objectPropertyValue) {
                    unset($this->map[$objectClass][$key]);
                }
            }
        }
    }

    function get($objectClass, $objectProperty, $objectPropertyValue) {
        if (isset($this->map[$objectClass])) {
            foreach ($this->map[$objectClass] as $object) {
                if ($object->get()->$objectProperty === $objectPropertyValue) {
                    return $object;
                }
            }
        } else {
            $this->map[$objectClass] = array();
        }

        return null;
    }

    function clear() {
        $this->map = array();
    }

}
