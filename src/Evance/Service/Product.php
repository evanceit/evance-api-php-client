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
        $properties = (new EvObject([

        ]))->merge($properties);
        parent::__construct($client, new ProductsResource($client), 'product',  $properties);
    }

    /**
     * @param string $sku The unique Stock Keeping Unit identifier.
     * @return bool
     */
    public function fetchBySku($sku)
    {
        $resource = $this->getResource();
        $results = $resource->search(['skus' => $sku]);
        $products = $results['products'];
        if (!count($products)) {
            return false;
        }
        $this->setProperties($products[0]);
        return true;
    }
    
    public function isStocked()
    {
        return $this->getIsStocked();
    }
}