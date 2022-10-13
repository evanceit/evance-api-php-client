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
     * @param $id
     * @return array
     */
    public function get($id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('GET', "/{$this->version}/products/{$id}.json");
    }

    /**
     * @param $query
     * @return mixed
     */
    public function search(array $parameters = [])
    {
        Assert::isArray($parameters, __METHOD__ . ' expects $query to be supplied as an array of key value pairs');
        return $this->call('GET', "/{$this->version}/products.json", [], $parameters);
    }

    /**
     * @param $product
     * @return mixed
     */
    public function add($product)
    {
        Assert::isArray($product, __METHOD__ . ' expects $product to be supplied as an array');
        Assert::keyExists($product, "product",  __METHOD__ . ' expects $product to contain key of "product"' .
            ' with value of object or array:');
        return $this->call('POST', "/{$this->version}/products.json", $product);
    }

    /**
     * @param $id
     * @param $product
     * @return mixed
     */
    public function update($id, $product)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        Assert::isArray($product, __METHOD__ . ' expects $product to be supplied as an array');
        Assert::keyExists($product, "product",  __METHOD__ . ' expects $product to contain key of "product"' .
            ' with value of json object');
        return $this->call('PUT', "/{$this->version}/products/{$id}.json", $product);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('DELETE', "/{$this->version}/products/{$id}.json");
    }
}
