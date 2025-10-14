<?php

namespace Evance\Resource;

use Evance\AbstractResource;
use Evance\ApiClient;
use Webmozart\Assert\Assert;

class Events extends AbstractResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getOne(int $id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('GET', "/{$this->version}events/{$id}.json");
    }

    /**
     * List/search events
     * @param array $params
     * @return mixed
     */
    public function getMany(array $params = [])
    {
        Assert::isArray($params, __METHOD__ . ' expects $params to be supplied as an array of key value pairs');
        return $this->call('GET', "/{$this->version}events.json", [], $params);
    }

    /**
     * Create a event
     * @param array $body
     * @return mixed
     */
    public function postOne(array $body)
    {
        Assert::isArray($body, __METHOD__ . ' expects $body to be supplied as an array');
        Assert::keyExists($body, "data", __METHOD__ . ' expects $body to contain key of "data" with value of object or array');
        return $this->call('POST', "/{$this->version}events.json", $body);
    }

    /**
     * Update a event
     * @param int $id
     * @param array $body
     * @return mixed
     */
    public function putOne(int $id, array $body)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        Assert::isArray($body, __METHOD__ . ' expects $body to be supplied as an array');
        Assert::keyExists($body, "data", __METHOD__ . ' expects $body to contain key of "data" with value of json object');
        return $this->call('PUT', "/{$this->version}events/{$id}.json", $body);
    }

    /**
     * Delete a event
     * @param int $id
     * @return mixed
     */
    public function deleteOne(int $id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('DELETE', "/{$this->version}events/{$id}.json");
    }
}