<?php
namespace Evance\Resource;

use Evance\AbstractResource;
use Evance\ApiClient;
use Webmozart\Assert\Assert;

class Inventory extends AbstractResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    /**
     * @param $id
     * @return array
     */
    public function getOne(int $id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('GET', "/".$this->version."inventory/{$id}.json");
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getMany(array $params = [])
    {
        Assert::isArray($params, __METHOD__ . ' expects $query to be supplied as an array of key value pairs');
        return $this->call('GET', "/".$this->version."inventory.json", [], $params);
    }

    /**
     * @param $body
     * @return mixed
     */
    public function postOne(array $body)
    {
        Assert::isArray($body, __METHOD__ . ' expects $body to be supplied as an array');
        Assert::keyExists($body, "data",  __METHOD__ . ' expects $body to contain key of "data"' .
            ' with value of object or array:');
        return $this->call('POST', "/".$this->version."inventory.json", $body);
    }

    /**
     * @param $id
     * @param $body
     * @return mixed
     */
    public function putOne(int $id, array $body)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        Assert::isArray($body, __METHOD__ . ' expects $body to be supplied as an array');
        Assert::keyExists($body, "data",  __METHOD__ . ' expects $body to contain key of "data"' .
            ' with value of json object');
        return $this->call('PUT', "/".$this->version."inventory/{$id}.json", $body);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteOne(int $id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('DELETE', "/".$this->version."inventory/{$id}.json");
    }

    /**
     * @param $inventory
     * @return mixed
     * @deprecated use postOne()
     */
    public function add($inventory)
    {
        return $this->postOne($inventory);
    }

    /**
     * @param $id
     * @return array
     * @deprecated use getOne()
     */
    public function get($id)
    {
        return $this->getOne($id);
    }

    /**
     * @param $id
     * @param $inventory
     * @return mixed
     * @deprecated use putOne()
     */
    public function update($id, $inventory)
    {
        return $this->putOne($id, $inventory);
    }

    /**
     * @param $params
     * @return mixed
     * @deprecated use getMany()
     */
    public function search($params = [])
    {
        return $this->getMany($params);
    }

    /**
     * @param $id
     * @return mixed
     * @deprecated use deleteOne()
     */
    public function delete($id)
    {
        return $this->deleteOne($id);
    }
}
