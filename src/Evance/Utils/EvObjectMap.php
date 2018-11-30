<?php

namespace Evance\Utils;

use Evance\Literal\EvObject;

/**
 * Class EvObjectMap
 *
 * Maps an object/array to another object/array by add()ing one or more PropertyMap
 *
 * @package Evance\Utils
 * @see https://www.evance.me/help/api/client-libraries/php/mapper-utilities
 */
class EvObjectMap extends EvObject
{

    /**
     * EvObjectMap constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param PropertyMap $propertyMap
     * @return EvObjectMap
     */
    public function add(PropertyMap $propertyMap)
    {
        $this->set($propertyMap->getKey(), $propertyMap);
        return $this;
    }

    /**
     * @param bool $strict
     * @return $this
     * @throws \ReflectionException
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
     *
     * @param bool $strict
     * @return EvObjectMap
     * @throws \ReflectionException
     */
    public function assignLeftToRight($strict = true)
    {
        return $this->assignRight($strict);
    }

    /**
     * @param bool $strict
     * @return $this
     * @throws \ReflectionException
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
     *
     * @param bool $strict
     * @return EvObjectMap
     * @throws \ReflectionException
     */
    public function assignRightToLeft($strict = true)
    {
        return $this->assignLeft($strict);
    }

}