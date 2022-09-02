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
    public function get($id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('GET', "/".$this->version."inventory/{$id}.json");
    }

    /**
     * @param $parameters
     * @return mixed
     */
    public function search(array $parameters = [])
    {
        Assert::isArray($parameters, __METHOD__ . ' expects $query to be supplied as an array of key value pairs');
        return $this->call('GET', "/".$this->version."inventory.json", [], $parameters);
    }

    /**
     * @param $inventory
     * @return mixed
     */
    public function add($inventory)
    {
        Assert::isArray($inventory, __METHOD__ . ' expects $inventory to be supplied as an array');
        Assert::keyExists($inventory, "data",  __METHOD__ . ' expects $inventory to contain key of "data"' .
            ' with value of object or array:');
        return $this->call('POST', "/".$this->version."inventory.json", $inventory);
    }

    /**
     * @param $id
     * @param $inventory
     * @return mixed
     */
    public function update($id, $inventory)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        Assert::isArray($inventory, __METHOD__ . ' expects $inventory to be supplied as an array');
        Assert::keyExists($inventory, "data",  __METHOD__ . ' expects $inventory to contain key of "data"' .
            ' with value of json object');
        return $this->call('PUT', "/".$this->version."inventory/{$id}.json", $inventory);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('DELETE', "/".$this->version."inventory/{$id}.json");
    }
}
