<?php

namespace Evance\Literal;

use Evance\Traits\PropertiesArrayTrait;
use Evance\Traits\PropertiesIteratorTrait;

/**
 * Class Object
 * @package Ev\Literal
 */
class Object extends AbstractLiteral implements \Iterator, \Countable
{

    use PropertiesArrayTrait;
    use PropertiesIteratorTrait;

    /**
     * Initiate a basic object using a properties array.
     * @param array|\stdClass|\Evance\Literal\Object $properties
     */
    public function __construct($properties = [])
    {
        $this->setProperties($properties);
    }

    /**
     * Magic method sets up get and set calls for properties.
     * For example, an object with a 'name' property will automatically allow the methods
     * getName() and setName(). These may also be overwritten within the extending class.
     *
     * I would advise that any class relying on the magic __call() method must define the available methods
     * using phpDoc comments as this will also assist in refactoring.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (preg_match('/^(get|set)([A-Z][\w]+)$/', $name, $matches)) {
            $action = $matches[1];
            $property = lcfirst($matches[2]);
            if (!$this->has($property)) {
                throw new \RuntimeException(__CLASS__ . "::{$name}() method does not exist.");
            }
            array_unshift($arguments, $property);
            return call_user_func_array([$this, $action], $arguments);
        }
        throw new \RuntimeException(__CLASS__ . "::{$name}() method does not exist.");
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        $name = $this->resolvePropertyName($name);
        if ($this->has($name)) {
            return $this->properties[$name];
        }
        return parent::get($name);
    }

    /**
     * Returns an integer value of the length() method.
     * This allows Objects to be used with PHP's count() function.
     * @return int
     */
    public function count()
    {
        return $this->length();
    }

    /**
     * Returns the internal array of properties
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Returns an array of keys from the internal properties associative array.
     * @return array
     */
    public function keys()
    {
        return array_keys($this->properties);
    }

    /**
     * The total number of properties/elements within the object.
     * @return int
     */
    public function length()
    {
        return count($this->properties);
    }

    /**
     * Put a property and value into the properties array.
     * @param string $property
     * @param mixed $value
     * @return \Evance\Literal\Object
     */
    public function put($property, $value)
    {
        $this->set($property, $value);
        return $this;
    }

    /**
     * Resets the internal properties to an empty array.
     * @return \Evance\Literal\Object
     */
    public function resetProperties()
    {
        $this->properties = [];
        return $this;
    }

    /**
     * Set a property with an type of value.
     *
     * @param string $name
     * @param mixed $value
     * @return \Evance\Literal\Object
     */
    public function set($name, $value)
    {
        $this->properties[$this->resolvePropertyName($name)] = $value;
        return $this;
    }

    /**
     * Resets the internal properties array to a new set of properties.
     * @param $properties
     * @return \Evance\Literal\Object
     */
    public function setProperties($properties)
    {
        $this->properties = $this->resolvePropertiesArgument($properties);
        return $this;
    }

    /**
     * Returns a JSON encoded string of the Object's properties.
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Returns a native string representation of the Object.
     * @return string
     */
    public function toString()
    {
        $className = get_called_class();
        return "[Object {$className}]";
    }

}