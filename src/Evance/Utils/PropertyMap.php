<?php

namespace Evance\Utils;

use Evance\Literal\EvObject;

/**
 * Class PropertyMap
 *
 * Maps a property for an object/array to that of another object/array.
 * The property map is designed to be used in conjunction with an EvObjectMap.
 *
 * @package Evance\Utils
 * @see https://www.evance.me/help/api/client-libraries/php/mapper-utilities
 */
class PropertyMap
{

    /** @var mixed */
    private $leftObject;

    /** @var string */
    private $leftProperty;

    /** @var mixed */
    private $rightObject;

    /** @var string */
    private $rightProperty;

    /**
     * PropertyMap constructor.
     * @param mixed $leftObject
     * @param string $leftProperty
     * @param mixed $rightObject
     * @param string $rightProperty
     */
    public function __construct(&$leftObject, $leftProperty, &$rightObject, $rightProperty)
    {
        $this->setLeft($leftObject, $leftProperty);
        $this->setRight($rightObject, $rightProperty);
    }

    /**
     * Gets the right side value and assigns it to the left object's property.
     *
     * @param bool $strict
     * @return $this
     * @throws \ReflectionException
     */
    public function assignLeft($strict = true)
    {
        if ($strict && !$this->hasMatchingProperties()) {
            return $this;
        } elseif (!$this->hasRightProperty()) {
            return $this; 
        }
        $this->assignValue($this->getLeftObject(), $this->getLeftProperty(), $this->getRightValue());
        return $this;
    }

    /**
     * Alias of assignRight()
     *
     * @param bool $strict
     * @return PropertyMap
     * @throws \ReflectionException
     */
    public function assignLeftToRight($strict = true)
    {
        return $this->assignRight($strict);
    }

    /**
     * Gets the left side value and assigns it to the right EvObject's property.
     *
     * @param bool $strict
     * @return $this
     * @throws \ReflectionException
     */
    public function assignRight($strict = true)
    {
        if ($strict && !$this->hasRightProperty() || !$this->hasLeftProperty()) {
            return $this;
        } elseif (!$this->hasLeftProperty()) {
            return $this;
        }
        $this->assignValue($this->getRightObject(), $this->getRightProperty(), $this->getLeftValue());
        return $this;
    }

    /**
     * Alias of assignleft()
     *
     * @param bool $strict
     * @return PropertyMap
     * @throws \ReflectionException
     */
    public function assignRightToLeft($strict = true)
    {
        return $this->assignLeft($strict);
    }

    /**
     * Attempts to assign a value to the property of an object or associative array.
     *
     * @param $object
     * @param $property
     * @param $value
     * @return $this
     * @throws \ReflectionException
     */
    private function assignValue($object, $property, $value)
    {
        if (is_object($object)) {
            $methodName = 'set' . ucfirst($property);
            $reflectedClass = new \ReflectionClass($object);
            if ($reflectedClass->hasMethod($methodName)) {
                $reflectedMethod = $reflectedClass->getMethod($methodName);
                if (
                    $reflectedMethod->isPublic() &&
                    $reflectedMethod->getNumberOfParameters() > 0 &&
                    $reflectedMethod->getNumberOfRequiredParameters() <= 1
                ) {
                    $reflectedMethod->invoke($object, $value);
                    return $this;
                }
            }
            if ($reflectedClass->hasProperty($property)) {
                $reflectedProperty = $reflectedClass->getProperty($property);
                if ($reflectedProperty->isPublic()) {
                    $reflectedProperty->setValue($object, $value);
                    return $this;
                }
            }
        }
        if ($object instanceof EvObject) {
            $object->set($property, $value);
            return $this;
        }
        if ($object instanceof \stdClass) {
            $object->{$property} = $value;
            return $this;
        }
        if (is_array($object)) {
            $object[$property] = $value;
        }
        throw new \RuntimeException(__METHOD__ . " can't tell how to assign '{$property}' to its object.");
    }

    /**
     * Returns the object to map on the left side of the assignment operation.
     * @return mixed
     */
    public function getLeftObject()
    {
        return $this->leftObject;
    }

    /**
     * Returns the property name of the object to map on the left side of the assignment operation.
     * @return string
     */
    public function getLeftProperty()
    {
        return $this->leftProperty;
    }

    /**
     * Returns the value stored in the left EvObject's property.     *
     * @return mixed
     * @throws \ReflectionException
     */
    public function getLeftValue()
    {
        return $this->getValueFrom($this->getLeftObject(), $this->getLeftProperty());
    }

    /**
     * Generates a unique'ish key for the assignment
     * @return string
     */
    public function getKey()
    {
        $parts = [
            $this->getLeftProperty(),
            $this->getRightProperty()
        ];
        $key = implode('-', $parts);
        return md5($key);
    }

    /**
     * Returns the object to map on the right side of the assignment operation.
     * @return mixed
     */
    public function getRightObject()
    {
        return $this->rightObject;
    }

    /**
     * Returns the property name of the object to map on the right side of the assignment operation.
     * @return string
     */
    public function getRightProperty()
    {
        return $this->rightProperty;
    }

    /**
     * Returns the value stored in the right EvObject's property.
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public function getRightValue()
    {
        return $this->getValueFrom($this->getRightObject(), $this->getRightProperty());
    }

    /**
     * Attempts to get a value of a property from an object or associative array.
     *
     * @param $object
     * @param $property
     * @return mixed
     * @throws \ReflectionException
     */
    public function getValueFrom($object, $property)
    {
        if (is_object($object)) {
            $methodName = 'get' . ucfirst($property);
            $reflectedClass = new \ReflectionClass($object);
            if ($reflectedClass->hasMethod($methodName)) {
                $reflectedMethod = $reflectedClass->getMethod($methodName);
                if (
                    $reflectedMethod->isPublic() &&
                    $reflectedMethod->getNumberOfRequiredParameters() === 0
                ) {
                    return $reflectedMethod->invoke($object);
                }
            }
            if ($reflectedClass->hasProperty($property)) {
                $reflectedProperty = $reflectedClass->getProperty($property);
                if ($reflectedProperty->isPublic()) {
                    return $reflectedProperty->getValue($object);
                }
            }
        }
        if ($object instanceof EvObject) {
            return $object->get($property);
        }
        if ($object instanceof \stdClass) {
            return $object->{$property};
        }
        if (is_array($object)) {
            return $object[$property];
        }
        throw new \RuntimeException(__METHOD__ . " can't tell how to get '{$property}' from its object.");
    }

    /**
     * @return bool
     * @throws \ReflectionException
     */
    public function hasLeftProperty()
    {
        return $this->hasProperty($this->getLeftObject(), $this->getLeftProperty());
    }

    /**
     * @return bool
     * @throws \ReflectionException
     */
    public function hasMatchingProperties()
    {
        return ($this->hasLeftProperty() && $this->hasRightProperty());
    }

    /**
     * Tries to determine if a property exists within an object or associative array.
     *
     * @param $object
     * @param $property
     * @return bool
     * @throws \ReflectionException
     */
    public function hasProperty($object, $property)
    {
        if (is_object($object)) {
            $reflectedClass = new \ReflectionClass($object);
            $getMethod = 'get' . ucfirst($property);
            $setMethod = 'set' . ucfirst($property);
            if ($reflectedClass->hasProperty($property)) {
                $reflectedProperty = $reflectedClass->getProperty($property);
                if ($reflectedProperty->isPublic()) {
                    return true;
                }
            }
            if (
                $reflectedClass->hasMethod($getMethod) &&
                $reflectedClass->hasMethod($setMethod)
            ) {
                return true;
            }
        }
        if ($object instanceof EvObject) {
            return $object->has($property);
        }
        if ($object instanceof \stdClass) {
            return property_exists($object, $property);
        }
        if (is_array($object)) {
            return array_key_exists($property, $object);
        }
        throw new \RuntimeException(__METHOD__ . " can't tell how to determine if object has property '{$property}'.");
    }

    /**
     * @return bool
     * @throws \ReflectionException
     */
    public function hasRightProperty()
    {
        return $this->hasProperty($this->getRightObject(), $this->getRightProperty());
    }

    /**
     * Allows you to set the object and property pair for the left side of the assignment operation.
     *
     * @param $object
     * @param string $property
     * @return PropertyMap
     */
    public function setLeft(&$object, $property)
    {
        $this->setLeftObject($object);
        $this->setLeftProperty($property);
        return $this;
    }

    /**
     * Allows you to set the object for the left side of the assignment operation.
     *
     * @param mixed $object
     * @return PropertyMap
     */
    public function setLeftObject(&$object)
    {
        $this->leftObject = &$object;
        return $this;
    }

    /**
     * Allows you to set the property for the left side of the assignment operation.
     *
     * @param string $property
     * @return PropertyMap
     */
    public function setLeftProperty($property)
    {
        $this->leftProperty = $property;
        return $this;
    }

    /**
     * Allows you to set the object and property pair for the right side of the assignment operation.
     *
     * @param $object
     * @param string $property
     * @return PropertyMap
     */
    public function setRight(&$object, $property)
    {
        $this->setRightObject($object);
        $this->setRightProperty($property);
        return $this;
    }

    /**
     * Allows you to set the object for the right side of the assignment operation.
     *
     * @param $object
     * @return PropertyMap
     */
    public function setRightObject(&$object)
    {
        $this->rightObject = &$object;
        return $this;
    }

    /**
     * Allows you to set the property for the right side of the assignment operation.
     *
     * @param string $property
     * @return PropertyMap
     */
    public function setRightProperty($property)
    {
        $this->rightProperty = $property;
        return $this;
    }


}