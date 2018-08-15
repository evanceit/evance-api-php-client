<?php

namespace Evance\Resource;

use Evance\AbstractResource;
use Evance\ApiClient;
use Webmozart\Assert\Assert;

class Branches extends AbstractResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    /**
     * Create a new Branch for the App.
     * @param $properties
     * @return mixed
     */
    public function add($properties)
    {
        Assert::isArray($properties, __METHOD__ . ' expects $properties to be supplied as an array');
        return $this->call('POST', "/branches.json", $properties);
    }

    /**
     * Add a contact to a branch for the App.
     * @param $branchId
     * @param $properties
     * @return mixed
     */
    public function addContactToBranch($branchId, $properties)
    {
        Assert::isArray($properties, __METHOD__ . ' expects $properties to be supplied as an array');
        return $this->call('POST', "/branches/{$branchId}/contact.json", $properties);
    }

    /**
     * Delete a Branch based on ID for the App.
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('DELETE', "/branches/{$id}.json");
    }

    /**
     * Get a Branch for the App.
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('GET', "/branches/{$id}.json");
    }

    /**
     * Search for Branches by reference.
     * @param $reference
     * @return mixed
     */
    public function searchByReference($reference)
    {
        return $this->call('GET', "/branches/search.json?reference={$reference}");
    }

    /**
     * Update a Branch for the App with the new properties provided.
     * @param $id
     * @param $properties
     * @return mixed
     */
    public function update($id, $properties)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        Assert::isArray($properties, __METHOD__ . ' expects $properties to be supplied as an array');
        return $this->call('PUT', "/branches/{$id}.json", $properties);
    }
}
