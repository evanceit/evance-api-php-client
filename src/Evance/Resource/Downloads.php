<?php

namespace Evance\Resource;

use Evance\AbstractResource;
use Evance\ApiClient;
use Webmozart\Assert\Assert;

class Downloads extends AbstractResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    /**
     * @param int $productId
     * @param int $downloadId
     * @return array
     */
    public function getById($downloadId, $productId)
    {
        Assert::integerish($productId, __METHOD__ . ' expects an $productId as an integer');
        Assert::integerish($downloadId, __METHOD__ . ' expects an $downloadId as an integer');
        return $this->call('GET', "/{$this->version}products/{$productId}/downloads/{$downloadId}.json");
    }

    /**
     * @param int $productId
     * @param array $params
     * @return array
     */
    public function getMany($productId, array $params)
    {
        Assert::integerish($productId, __METHOD__ . ' expects an $productId as an integer');
        Assert::isArray($params, __METHOD__ . ' expects $params to be an array of key value pairs');
        return $this->call('GET', "/{$this->version}products/{$productId}/downloads.json", [], $params);
    }

    /**
     * @param int $productId
     * @param array $body
     * @return mixed
     */
    public function addOne($productId, array $body)
    {
        Assert::integerish($productId, __METHOD__ . ' expects an $productId as an integer');
        Assert::isArray($body, __METHOD__ . ' expects $body to be supplied as an array');
        Assert::keyExists($body, "data", __METHOD__ . ' expects $body to contain key of "data" with value of object or array:');
        return $this->call('POST', "/{$this->version}products/{$productId}/downloads.json", $body);
    }

    /**
     * @param int $downloadId
     * @param int $productId
     * @param array $body
     * @return mixed
     */
    public function updateOne($productId, $downloadId, array $body)
    {
        Assert::integerish($productId, __METHOD__ . ' expects an $productId as an integer');
        Assert::integerish($downloadId, __METHOD__ . ' expects an $downloadId as an integer');
        Assert::isArray($body, __METHOD__ . ' expects $body to be supplied as an array');
        Assert::keyExists($body, "data", __METHOD__ . ' expects $body to contain key of "data" with value of json object');
        return $this->call('PUT', "/{$this->version}products/{$productId}/downloads/{$downloadId}.json", $body);
    }
}
