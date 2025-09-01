<?php


namespace Evance\Resource;

use Evance\AbstractResource;
use Evance\ApiClient;
use Webmozart\Assert\Assert;

class Categories extends AbstractResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    /**
     * @param int|string $id
     * @return array
     */
    public function getOne($id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('GET', "/{$this->version}categories/{$id}.json");
    }

    /**
     * List/search categories
     * @param array $params
     * @return mixed
     */
    public function getMany(array $params = [])
    {
        Assert::isArray($params, __METHOD__ . ' expects $params to be supplied as an array of key value pairs');
        return $this->call('GET', "/{$this->version}categories.json", [], $params);
    }

    /**
     * Create a category
     * @param array $body
     * @return mixed
     */
    public function postOne(array $body)
    {
        Assert::isArray($body, __METHOD__ . ' expects $body to be supplied as an array');
        Assert::keyExists($body, "data", __METHOD__ . ' expects $body to contain key of "data" with value of object or array');
        return $this->call('POST', "/{$this->version}categories.json", $body);
    }

    /**
     * Update a category
     * @param int|string $id
     * @param array $body
     * @return mixed
     */
    public function putOne($id, array $body)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        Assert::isArray($body, __METHOD__ . ' expects $body to be supplied as an array');
        Assert::keyExists($body, "data", __METHOD__ . ' expects $body to contain key of "data" with value of json object');
        return $this->call('PUT', "/{$this->version}categories/{$id}.json", $body);
    }

    /**
     * Delete a category
     * @param int|string $id
     * @return mixed
     */
    public function deleteOne($id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('DELETE', "/{$this->version}categories/{$id}.json");
    }
}