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
     * @param $body
     * @return mixed
     */
    public function postOne($body)
    {
        Assert::isArray($body, __METHOD__ . ' expects $properties to be supplied as an array');
        $key = ($this->version !== AbstractResource::V2) ? "contact" : "data";
        $this->assertBody($body, $key);
        return $this->call('POST', "/contacts.json", $body);
    }

    /**
     * Update a Contact for the App with the new properties provided.
     * @param $id
     * @param $body
     * @return mixed
     */
    public function putOne($id, $body)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        Assert::isArray($body, __METHOD__ . ' expects $body to be supplied as an array');
        $key = ($this->version !== AbstractResource::V2) ? "contact" : "data";
        $this->assertBody($body, $key);
        return $this->call('PUT', "/contacts/{$id}.json", $body);
    }

    /**
     * Delete a Contact based on ID for the App.
     * @param $id
     * @return mixed
     */
    public function deleteOne($id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('DELETE', "/contacts/{$id}.json");
    }

    /**
     * Get a Contact for the App.
     * @param $id
     * @return mixed
     */
    public function getOne($id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('GET', "/contacts/{$id}.json");
    }

    /**
     * Search for Contact(s) based on certain parameters within a query string.
     * @param array $params
     * @return mixed
     */
    public function getMany(array $params = [])
    {
        return $this->call('GET', "/contacts/search.json", [], $params);
    }

    /**
     * Search for a single user by reference
     * @param $reference
     * @return mixed
     * @deprecated use getMany()
     */
    public function searchWithReference($reference)
    {
        return $this->call('GET', "/contacts/search.json?reference={$reference}");
    }

    /**
     * @param $email
     * @return mixed
     * @deprecated Use getMany()
     */
    public function searchWithEmail($email)
    {
        return $this->call('GET', "/contacts/search.json?email={$email}");
    }

    /**
     * @param $leaveDate
     * @return mixed
     * @deprecated use getMany()
     */
    public function searchWithLeaveDate($leaveDate)
    {
        return $this->call('GET', "/contacts/search.json?leaveDate={$leaveDate}");
    }

    /**
     * @param $properties
     * @return mixed
     * @deprecated use postOne()
     */
    public function add($properties)
    {
        return $this->postOne($properties);
    }

    /**
     * @param $id
     * @param $properties
     * @return mixed
     * @deprecated use putOne()
     */
    public function update($id, $properties)
    {
        return $this->putOne($id, $properties);
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

    /**
     * @param mixed $query
     * @return mixed|string[]
     * @deprecated use getMany()
     */
    public function search($query)
    {
        if (is_string($query)) {
            parse_str($query, $query);
        }
        return $this->getMany($query);
    }
}
