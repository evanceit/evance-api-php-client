<?php
namespace Evance\Resource;

use Evance\AbstractResource;
use Evance\ApiClient;
use Webmozart\Assert\Assert;

class Locations extends AbstractResource
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
        return $this->call('GET', "/".$this->version."locations/{$id}.json");
    }

    /**
     * @param $query
     * @return mixed
     */
    public function search(array $parameters = [])
    {
        Assert::isArray($parameters, __METHOD__ . ' expects $query to be supplied as an array of key value pairs');
        return $this->call('GET', "/".$this->version."locations.json", [], $parameters);
    }
}
