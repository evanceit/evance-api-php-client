<?php

namespace Evance\Resource;

use Evance\AbstractResource;
use Evance\ApiClient;
use Webmozart\Assert\Assert;

class Webhooks extends AbstractResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    /**
     * @param int $webhookId
     * @return array
     */
    public function getOne(int $webhookId)
    {
        Assert::integerish($webhookId, __METHOD__ . ' expects an $productId as an integer');
        return $this->call('GET', "/{$this->version}webhooks/{$webhookId}.json");
    }

    /**
     * @param array $params
     * @return array
     */
    public function getMany(array $params)
    {
        Assert::isArray($params, __METHOD__ . ' expects $params to be an array of key value pairs');
        return $this->call('GET', "/{$this->version}webhooks.json", [], $params);
    }

    /**
     * @param int $webhookId
     * @param array $body
     * @return mixed
     */
    public function addOne(int $webhookId, array $body)
    {
        Assert::integerish($webhookId, __METHOD__ . ' expects an $productId as an integer');
        Assert::isArray($body, __METHOD__ . ' expects $body to be supplied as an array');
        Assert::keyExists($body, "data", __METHOD__ . ' expects $body to contain key of "data" with value of object or array:');
        return $this->call('POST', "/{$this->version}webhooks/{$webhookId}.json", $body);
    }

    /**
     * @param int $webhookId
     * @param array $body
     * @return mixed
     */
    public function updateOne(int $webhookId, array $body)
    {
        Assert::integerish($webhookId, __METHOD__ . ' expects an $productId as an integer');
        Assert::isArray($body, __METHOD__ . ' expects $body to be supplied as an array');
        Assert::keyExists($body, "data", __METHOD__ . ' expects $body to contain key of "data" with value of json object');
        return $this->call('PUT', "/{$this->version}webhooks/{$webhookId}.json", $body);
    }
}
