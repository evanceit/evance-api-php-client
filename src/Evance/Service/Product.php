<?php

namespace Evance\Service;

use Evance\AbstractService;
use Evance\ApiClient;
use Evance\Literal\Object;
use Evance\Resource\Products as ProductsResource;
use Evance\Resource\Products;

/**
 * @method bool getIsStocked()
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
        // First a new Evance\Literal\Object is created with a 
        $properties = (new Object([
            'isStocked'     => true,
            'firstname'     => '',
            'surname'       => '',
            'type'          => 'user',
            'username'      => ''
        ]))->merge($properties);
        parent::__construct($client, new ProductsResource($client), 'product',  $properties);
    }
    
    public function isStocked()
    {
        return $this->getIsStocked();
    }
}