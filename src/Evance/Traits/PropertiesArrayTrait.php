<?php

namespace Evance\Traits;

use Evance\Literal\AbstractLiteral;
use Evance\Literal\Object;

/**
 * Adds property management behaviour to Classes using an associative array.
 */
trait PropertiesArrayTrait
{

    /**
     * @var array The property storage array where all the goodies are stored.
     */
	protected $properties = [];

    /**
     * Magic method gets the value of a property.
     *
     * @param string $name
     * @return mixed
     * @see getProperty
     */
	public function __get($name)
    {
		return $this->get($name);
	}

    /**
     * Magic method determines whether the property exists
     *
     * @param string $name
     * @return boolean
     * @see has
     */
	public function __isset($name)
    {
		return $this->has($name);
	}

    /**
     * Magic method sets a property's value if the name is used in an assignment.
     *
     * @param string $name
     * @param mixed $value
     * @see setProperty
     */
	public function __set($name, $value)
    {
		$this->set($name, $value);
	}

    /**
     * Magic method to remove a property from the properties array
     *
     * @param string $name
     * @see deleteProperty
     */
    public function __unset($name)
    {
        $this->delete($name);
    }

    /**
     * Remove a property from the properties array
     * @param string $name
     * @return $this
     */
    public function delete($name)
    {
        $name = $this->resolvePropertyName($name);
        if ($this->has($name)) {
            unset($this->properties[$name]);
        }
        return $this;
    }

    /**
     * Extend the supplied properties with the current set of properties.
     * The properties supplied are overwritten by the current ones.
     *
     * @param array|\Evance\Literal\Object|\stdClass $properties
     * @return $this
     */
    public function extend($properties)
    {
        $properties = $this->resolvePropertiesArgument($properties);
        $this->properties = array_merge($properties, $this->properties);
        return $this;
    }

    /**
     * Returns the value of the property.
     *
     * @param string $name
     * @param null $default
     * @return mixed
     */
	public function get($name, $default = null)
    {
        $name = $this->resolvePropertyName($name);
		if (!$this->has($name)) {
		    return $default;
		}
		return $this->properties[$name];
	}

    /**
     * Returns TRUE if the property name exists, else FALSE.
     *
     * @param string $name
     * @return boolean
     */
    public function has($name)
    {
        $name = $this->resolvePropertyName($name);
        return isset($this->properties[$name]);
    }

    /**
     * Merge an array into the properties array.
     * Any existing properties are overwritten by the new properties supplied.
     *
     * @param array|Object $properties
     * @return $this
     */
    public function merge($properties)
    {
        $properties = $this->resolvePropertiesArgument($properties);
        $this->properties = array_merge($this->properties, $properties);
        return $this;
    }

    /**
     * Set a property with an type of value.
     *
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function set($name, $value)
    {
        $name = $this->resolvePropertyName($name);
        $this->properties[$name] = $value;
        return $this;
    }

    /**
     * Attempts to resolve different methods of supplying a property name.
     * The method will try to decipher whether a number or a string should be used.
     * @param $name
     * @return int|string
     */
    protected function resolvePropertyName($name)
    {
        if ($name instanceof AbstractLiteral) {
            return $name->toString();
        }
        if(is_numeric($name) && is_integer(($name  + 0))){
            return ($name + 0);
        }
        return strval($name);
    }

    /**
     * Accepts one of the following argument types and then converts them to an array:
     * - array
     * - stdClass
     * - Evance\Literal\Object
     * @param $properties
     * @return array
     */
    protected function resolvePropertiesArgument($properties)
    {
        if ($properties instanceof Object) {
            $properties = $properties->getProperties();
        } elseif ($properties instanceof \stdClass) {
            $properties = (array)$properties;
        }
        if (!is_array($properties)) {
            throw new \InvalidArgumentException('Invalid properties, expected array, stdClass or Ev\Literal\Object');
        }
        return $properties;
    }
	
}