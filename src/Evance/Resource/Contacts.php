<?php

namespace Evance\Resource;

use Evance\AbstractResource;
use Evance\ApiClient;
use Webmozart\Assert\Assert;

class Contacts extends AbstractResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    /**
     * Create a new Contact for the App.
     * @param $properties
     * @return mixed
     */
    public function add($properties)
    {
        Assert::isArray($properties, __METHOD__ . ' expects $properties to be supplied as an array');
        return $this->call('POST', "/contacts.json", $properties);
    }

    /**
     * Delete a Contact based on ID for the App.
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('DELETE', "/contacts/{$id}.json");
    }

    /**
     * Get a Contact for the App.
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('GET', "/contacts/{$id}.json");
    }

    /**
     * Search for Contact(s) based on certain parameters within a query string.
     * @param $query
     * @return mixed
     */
    public function search($query)
    {
        return $this->call('GET', "/contacts/search.json?q={$query}");
    }

    /**
     * Search for a single user by reference
     * @param $reference
     * @return mixed
     */
    public function searchWithReference($reference)
    {
        return $this->call('GET', "/contacts/search.json?ref={$reference}");
    }

    /**
     * @param $email
     * @return mixed
     */
    public function searchWithEmail($email)
    {
        return $this->call('GET', "/contacts/search.json?email={$email}");
    }

    /**
     * Update a Contact for the App with the new properties provided.
     * @param $id
     * @param $properties
     * @return mixed
     */
    public function update($id, $properties)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        Assert::isArray($properties, __METHOD__ . ' expects $properties to be supplied as an array');
        return $this->call('PUT', "/contacts/{$id}.json", $properties);
    }
}
