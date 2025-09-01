<?php

namespace Evance\Resource;

use Evance\AbstractResource;
use Evance\ApiClient;
use Webmozart\Assert\Assert;

class Pages extends AbstractResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    /**
     * @param int|string $id
     * @return mixed
     */
    public function getOne($id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        // v2 uses /documents, legacy uses /pages
        if ($this->version === self::V2) {
            return $this->call('GET', "/{$this->version}documents/{$id}.json");
        }
        return $this->call('GET', "/pages/{$id}.json");
    }

    /**
     * List/search pages
     * @param array $params
     * @return mixed
     */
    public function getMany(array $params = [])
    {
        Assert::isArray($params, __METHOD__ . ' expects $params to be supplied as an array of key value pairs');
        if ($this->version === self::V2) {
            return $this->call('GET', "/{$this->version}documents.json", [], $params);
        }
        return $this->call('GET', "/pages.json", [], $params);
    }

    /**
     * Create a page/document
     * @param array $body
     * @return mixed
     */
    public function postOne(array $body)
    {
        Assert::isArray($body, __METHOD__ . ' expects $body to be supplied as an array');
        Assert::keyExists($body, "data", __METHOD__ . ' expects $body to contain key of "data" with value of object or array');
        if ($this->version === self::V2) {
            return $this->call('POST', "/{$this->version}documents.json", $body);
        }
        return $this->call('POST', "/pages.json", $body);
    }

    /**
     * Update a page/document
     * @param int|string $id
     * @param array $body
     * @return mixed
     */
    public function putOne($id, array $body)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        Assert::isArray($body, __METHOD__ . ' expects $body to be supplied as an array');
        Assert::keyExists($body, "data", __METHOD__ . ' expects $body to contain key of "data" with value of json object');
        if ($this->version === self::V2) {
            return $this->call('PUT', "/{$this->version}documents/{$id}.json", $body);
        }
        return $this->call('PUT', "/pages/{$id}.json", $body);
    }

    /**
     * Delete a page/document
     * @param int|string $id
     * @return mixed
     */
    public function deleteOne($id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        if ($this->version === self::V2) {
            return $this->call('DELETE', "/{$this->version}documents/{$id}.json");
        }
        return $this->call('DELETE', "/pages/{$id}.json");
    }
}