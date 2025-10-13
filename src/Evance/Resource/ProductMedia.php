<?php

namespace Evance\Resource;

use Evance\AbstractChildResource;
use Evance\ApiClient;
use Webmozart\Assert\Assert;

/**
 * @deprecated will be replaced by Products/Media
 */
class ProductMedia extends AbstractChildResource
{
    public function __construct(ApiClient $client, $parentId = null)
    {
        parent::__construct($client);
        $this->parentId = $parentId;
    }

    public function getMany(array $params = [], ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        Assert::integerish($parentId, __METHOD__ . ' expects an $parentId as an integer');
        Assert::isArray($params, __METHOD__ . ' expects $params to be an array of key value pairs');
        return $this->call('GET', "/products/{$parentId}/media.json", $params);
    }

    public function postOne(array $body, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        Assert::integerish($parentId, __METHOD__ . ' expects an $parentId as an integer');
        Assert::isArray($body, __METHOD__ . ' expects $body to be supplied as an array');
        Assert::keyExists($body, "media",  __METHOD__ . ' expects $body to contain key of "media"' .
            ' with value of object or array');
        return $this->call('POST', "/products/{$parentId}/media.json", $body);
    }

    /**
     * @param $id
     * @param int|null $parentId
     * @return mixed
     * @deprecated use getOne()
     */
    public function getById($id, ?int $parentId = null)
    {
        return $this->getOne($id, $parentId);
    }

    public function getOne(int $id, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        Assert::integerish($parentId, __METHOD__ . ' expects an $parentId as an integer');
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('GET', "/products/{$parentId}/media/{$id}.json");
    }

    public function putOne(int $id, array $body, ?int $parentId = null )
    {
        $parentId = $this->requireParentId($parentId);
        Assert::integerish($parentId, __METHOD__ . ' expects an $parentId as an integer');
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        Assert::isArray($body, __METHOD__ . ' expects $body to be supplied as an array');
        Assert::keyExists($body, "media",  __METHOD__ . ' expects $body to contain key of "media"' .
            ' with value of object or array');
        return $this->call('PUT', "/products/{$parentId}/media/{$id}.json", $body);
    }

    public function deleteOne(int $id, ?int $parentId = null)
    {
        Assert::integerish($parentId, __METHOD__ . ' expects an $parentId as an integer');
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('DELETE', "/products/{$parentId}/media/{$id}.json");
    }
}
