<?php

namespace Evance\Resource;

use Evance\AbstractResource;
use Evance\ApiClient;
use Webmozart\Assert\Assert;

class ProductSpecification extends AbstractResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    public function get($productId)
    {
        Assert::integerish($productId, __METHOD__ . ' expects an $productId as an integer');
        return $this->call('GET', "/products/{$productId}/specifications.json");
    }

    public function add($productId, $specification)
    {
        Assert::integerish($productId, __METHOD__ . ' expects an $productId as an integer');
        Assert::isArray($specification, __METHOD__ . ' expects $specification to be supplied as an array');
        Assert::keyExists($specification, "specification",  __METHOD__ . ' expects $specification to contain key of "specification"' .
            ' with value of object or array');
        return $this->call('POST', "/products/{$productId}/specifications.json", $specification);
    }

    public function delete($productId, $valueId)
    {
        Assert::integerish($productId, __METHOD__ . ' expects an $productId as an integer');
        Assert::integerish($valueId, __METHOD__ . ' expects an $valueId as an integer');
        return $this->call('DELETE', "/products/{$productId}/specifications/{$valueId}.json");
    }
}
