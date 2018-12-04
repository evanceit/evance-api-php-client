<?php

namespace Evance\Traits;

/**
 * Adds Iterative behaviour to a the PropertiesArrayTrait for use where objects
 * require the ability to iterate through the properties array as if they are
 * properties of the EvObject.
 */
trait PropertiesIteratorTrait
{
    /**
     * Returns the current element in the internal properties array.
     * @return mixed
     */
    public function current()
    {
        return current($this->properties);
    }

    /**
     * Returns the key of the current element.
     * @return mixed
     */
    public function key()
    {
        return key($this->properties);
    }

    /**
     * Returns the number of properties within the EvObject's properties array.
     * @return integer
     */
    public function length()
    {
        return count($this->properties);
    }

    /**
     * Iterator: Move forward to next element
     * @return void
     */
    public function next()
    {
        next($this->properties);
        return;
    }

    /**
     * Rewind the Iterator pointer to the first property in the Array.
     * @return mixed
     */
    public function rewind()
    {
        reset($this->properties);
        return $this;
    }

    /**
     * Checks if current properties position is valid
     * @return boolean
     */
    public function valid()
    {
        return (key($this->properties) !== NULL);
    }
}