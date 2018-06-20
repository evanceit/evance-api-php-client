<?php

namespace Evance\Resource;

use Evance\AbstractResource;
use Evance\ApiClient;
use Webmozart\Assert\Assert;

class ProductMedia extends AbstractResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    public function get($productId)
    {
        Assert::integerish($productId, __METHOD__ . ' expects an $productId as an integer');
        return $this->call('GET', "/products/{$productId}/media.json");
    }

    public function add($productId, $media)
    {
        Assert::integerish($productId, __METHOD__ . ' expects an $producId as an integer');
        Assert::isArray($media, __METHOD__ . ' expects $media to be supplied as an array');
        Assert::keyExists($media, "media",  __METHOD__ . ' expects $media to contain key of "media"' .
            ' with value of object or array');
        return $this->call('POST', "/products/{$productId}/media.json", $media);
    }

    public function getById($productId, $mediaId)
    {
        Assert::integerish($productId, __METHOD__ . ' expects an $productId as an integer');
        Assert::integerish($mediaId, __METHOD__ . ' expects an $mediaId as an integer');
        return $this->call('GET', "/products/{$productId}/media/{$mediaId}.json");
    }

    public function update($productId, $mediaId, $media)
    {
        Assert::integerish($productId, __METHOD__ . ' expects an $productId as an integer');
        Assert::integerish($mediaId, __METHOD__ . ' expects an $mediaId as an integer');
        Assert::isArray($media, __METHOD__ . ' expects $media to be supplied as an array');
        Assert::keyExists($media, "media",  __METHOD__ . ' expects $media to contain key of "media"' .
            ' with value of object or array');
        return $this->call('PUT', "/products/{$productId}/media/{$mediaId}.json", $media);
    }

    public function delete($productId, $mediaId)
    {
        Assert::integerish($productId, __METHOD__ . ' expects an $productId as an integer');
        Assert::integerish($mediaId, __METHOD__ . ' expects an $mediaId as an integer');
        return $this->call('DELETE', "/products/{$productId}/media/{$mediaId}.json");
    }
}
