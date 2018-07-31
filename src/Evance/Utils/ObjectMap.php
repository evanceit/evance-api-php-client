<?php

namespace Evance\Utils;

use Evance\Literal\Object;

/**
 * Class ObjectMap
 *
 * Maps an object/array to another object/array by add()ing one or more PropertyMap
 *
 * @package Evance\Utils
 * @see https://www.evance.me/help/api/client-libraries/php/mapper-utilities
 */
class ObjectMap extends Object
{

    /**
     * ObjectMap constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param PropertyMap $propertyMap
     * @return ObjectMap
     */
    public function add(PropertyMap $propertyMap)
    {
        $this->set($propertyMap->getKey(), $propertyMap);
        return $this;
    }

    /**
     * @return ObjectMap
     */
    public function assignLeft($strict = true)
    {
        foreach ($this->getProperties() as $key => $propertyMap) {
            /** @var PropertyMap  $propertyMap */
            $propertyMap->assignLeft($strict);
        }
        return $this;
    }

    /**
     * Alias of assignRight()
     * @see assignRight
     * @return ObjectMap
     */
    public function assignLeftToRight($strict = true)
    {
        return $this->assignRight($strict);
    }

    /**
     * @return ObjectMap
     */
    public function assignRight($strict = true)
    {
        foreach ($this->getProperties() as $key => $propertyMap) {
            /** @var PropertyMap  $propertyMap */
            $propertyMap->assignRight($strict);
        }
        return $this;
    }

    /**
     * Alias of assignleft()
     * @see assignLeft
     * @return ObjectMap
     */
    public function assignRightToLeft($strict = true)
    {
        return $this->assignLeft($strict);
    }

}