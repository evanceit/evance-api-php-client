<?php

namespace Evance\Resource;

use Evance\AbstractResource;
use Evance\ApiClient;
use Webmozart\Assert\Assert;

class Products extends AbstractResource
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
        return $this->call('GET', "/{$this->version}products/{$id}.json");
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getMany(array $params = [])
    {
        Assert::isArray($params, __METHOD__ . ' expects $params to be supplied as an array of key value pairs');
        return $this->call('GET', "/{$this->version}products.json", [], $params);
    }

    /**
     * @param array $body
     * @return mixed
     */
    public function postOne(array $body)
    {
        Assert::isArray($body, __METHOD__ . ' expects $product to be supplied as an array');
        $key = ($this->version !== AbstractResource::V2) ? "product" : "data";
        $this->assertBody($body, $key);
        return $this->call('POST', "/{$this->version}products.json", $body);
    }

    /**
     * @param int $id
     * @param array $body
     * @return mixed
     */
    public function putOne(int $id, array $body)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        Assert::isArray($body, __METHOD__ . ' expects $product to be supplied as an array');
        $key = ($this->version !== AbstractResource::V2) ? "product" : "data";
        $this->assertBody($body, $key);
        return $this->call('PUT', "/{$this->version}products/{$id}.json", $body);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteOne(int $id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('DELETE', "/{$this->version}products/{$id}.json");
    }

    /**
     * @param $id
     * @return array
     * @deprecated use getOne()
     */
    public function get($id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('GET', "/{$this->version}products/{$id}.json");
    }

    /**
     * @param array $params
     * @return mixed
     * @deprecated use getMany()
     */
    public function search($params = [])
    {
        Assert::isArray($params, __METHOD__ . ' expects $query to be supplied as an array of key value pairs');
        return $this->call('GET', "/{$this->version}products.json", [], $params);
    }

    /**
     * @param $product
     * @return mixed
     * @deprecated
     */
    public function add($product)
    {
        Assert::isArray($product, __METHOD__ . ' expects $product to be supplied as an array');
        $key = ($this->version !== AbstractResource::V2) ? "product" : "data";
        $this->assertBody($product, $key);
        return $this->call('POST', "/{$this->version}products.json", $product);
    }

    /**
     * @param $id
     * @param $product
     * @return mixed
     * @deprecated
     */
    public function update($id, $product)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        Assert::isArray($product, __METHOD__ . ' expects $product to be supplied as an array');
        $key = ($this->version !== AbstractResource::V2) ? "product" : "data";
        $this->assertBody($product, $key);
        return $this->call('PUT', "/{$this->version}products/{$id}.json", $product);
    }

    /**
     * @param $id
     * @return mixed
     * @deprecated
     */
    public function delete($id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('DELETE', "/{$this->version}products/{$id}.json");
    }

}
