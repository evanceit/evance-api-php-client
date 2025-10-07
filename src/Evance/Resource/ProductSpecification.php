<?php

namespace Evance\Resource;

use Evance\AbstractChildResource;
use Evance\ApiClient;
use Webmozart\Assert\Assert;

/**
 * @deprecated will be replaced by Products/Specifications
 */
class ProductSpecification extends AbstractChildResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    public function getMany(array $params = [], ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        Assert::integerish($parentId, __METHOD__ . ' expects an $productId as an integer');
        return $this->call('GET', "/products/{$parentId}/specifications.json", [], $params);
    }

    public function postOne($body, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        Assert::integerish($parentId, __METHOD__ . ' expects an $productId as an integer');
        Assert::isArray($body, __METHOD__ . ' expects $specification to be supplied as an array');
        Assert::keyExists($body, "specification",  __METHOD__ . ' expects $specification to contain key of "specification"' .
            ' with value of object or array');
        return $this->call('POST', "/products/{$parentId}/specifications.json", $body);
    }

    public function deleteOne($id, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        Assert::integerish($parentId, __METHOD__ . ' expects an $productId as an integer');
        Assert::integerish($id, __METHOD__ . ' expects an $valueId as an integer');
        return $this->call('DELETE', "/products/{$parentId}/specifications/{$id}.json");
    }
}
