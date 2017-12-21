<?php

namespace Evance\Traits;

/**
 * Class PropertiesArrayAccessTrait
 * Grants array style access to properties based objects.
 * @package Evance\Traits
 */
trait PropertiesArrayAccessTrait
{

    /**
     * @param $offset
     * @return mixed
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * @param $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param $offset
     * @param $value
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->properties[] = $value;
        } else {
            $this->set($offset, $value);
        }
    }

    /**
     * @param $offset
     */
    public function offsetUnset($offset)
    {
        $this->delete($offset);
    }

}