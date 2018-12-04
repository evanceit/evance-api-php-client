<?php

namespace Evance\Literal;

/**
 * Class AbstractLiteral
 * @package Evance\Literal
 */
abstract class AbstractLiteral
{
    /**
     * Magic method, returns a native string representation of the EvObject's value.
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @param $name
     * @return null
     * @throws \ReflectionException
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * @return object
     * @throws \ReflectionException
     */
    public static function create()
    {
        $objectClass = get_called_class();
        $objectReflection = new \ReflectionClass($objectClass);
        return $objectReflection->newInstanceArgs(func_get_args());
    }

    /**
     * @param $name
     * @return null
     * @throws \ReflectionException
     */
    public function get($name)
    {
        $name = $this->resolvePropertyName($name);
        if ($this->hasPseudoProperty($name)) {
            return $this->{$name}();
        }
        return null;
    }

    /**
     * @param $name
     * @return bool
     * @throws \ReflectionException
     */
    protected function hasPseudoProperty($name)
    {
        if (!method_exists($this, $name)) {
            return false;
        }
        $method = new \ReflectionMethod($this, $name);
        return (
            $method->isPublic() &&
            $method->getNumberOfRequiredParameters() === 0
        );
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
            $name = $name->toString();
        }
        if(is_numeric($name) && is_integer(($name  + 0))){
            return ($name + 0);
        }
        return strval($name);
    }

    /**
     * Extending classes MUST define a toString() method, which returns a
     * native string representation of the EvObject's value.
     * @return string
     */
    abstract public function toString();

}