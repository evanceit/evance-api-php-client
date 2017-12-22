<?php

namespace Evance\Utils;

use Evance\Literal\Object;

/**
 * Class ObjectMap
 *
 *
 *
 * @package Evance\Utils
 */
class ObjectMap extends Object
{

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
    public function assignLeft()
    {
        foreach ($this->getProperties() as $key => $propertyMap) {
            /** @var PropertyMap  $propertyMap */
            $propertyMap->assignLeft();
        }
        return $this;
    }

    /**
     * Alias of assignRight()
     * @see assignRight
     * @return ObjectMap
     */
    public function assignLeftToRight()
    {
        return $this->assignRight();
    }

    /**
     * @return ObjectMap
     */
    public function assignRight()
    {
        foreach ($this->getProperties() as $key => $propertyMap) {
            /** @var PropertyMap  $propertyMap */
            $propertyMap->assignRight();
        }
        return $this;
    }

    /**
     * Alias of assignleft()
     * @see assignLeft
     * @return ObjectMap
     */
    public function assignRightToLeft()
    {
        return $this->assignLeft();
    }

}