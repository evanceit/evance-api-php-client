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
    public function current(): mixed
    {
        return current($this->properties);
    }

    /**
     * Returns the key of the current element.
     * @return mixed
     */
    public function key(): mixed
    {
        return key($this->properties);
    }

    /**
     * Returns the number of properties within the EvObject's properties array.
     * @return integer
     */
    public function length(): int
    {
        return count($this->properties);
    }

    /**
     * Iterator: Move forward to next element
     * @return void
     */
    public function next(): void
    {
        next($this->properties);
        return;
    }

    /**
     * Rewind the Iterator pointer to the first property in the Array.
     * @return void
     */
    public function rewind(): void
    {
        reset($this->properties);
    }

    /**
     * Checks if current properties position is valid
     * @return boolean
     */
    public function valid(): bool
    {
        return (key($this->properties) !== NULL);
    }
}