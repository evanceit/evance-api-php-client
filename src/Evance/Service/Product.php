<?php

namespace Evance\Service;

use Evance\AbstractService;
use Evance\ApiClient;
use Evance\Literal\EvObject;
use Evance\Resource\Products as ProductsResource;
use Evance\Resource\Products;

/**
 * @method bool getIsStocked()
 *
 * @method Products getResource()
 *
 * @package Evance\Service\Product
 */
class Product extends AbstractService
{
    /**
     * Contact constructor.
     * @param ApiClient $client
     * @param array $properties
     */
    public function __construct(ApiClient $client, $properties = [])
    {
        // First a new Evance\Literal\EvObject is created with a
        $properties = (new EvObject([

        ]))->merge($properties);
        parent::__construct($client, new ProductsResource($client), 'product',  $properties);
    }

    public function fetchBySku($sku)
    {

        $resource = $this->getResource();
        var_dump($resource->search(['skus' => $sku]));
    }
    
    public function isStocked()
    {
        return $this->getIsStocked();
    }
}