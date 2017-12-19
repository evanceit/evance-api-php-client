<?php

namespace Evance\Resource;

use Evance\AbstractResource;
use Evance\App;
use Webmozart\Assert\Assert;

class Contacts extends AbstractResource
{
    public function __construct(App $client)
    {
        parent::__construct($client);
    }

    public function add($properties)
    {
        $json = $this->call('POST', "/contacts.json", $properties);
        return $json;
    }

    public function delete($id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        $json = $this->call('DELETE', "/contacts/{$id}.json");
        return $json;
    }

    public function get($id)
    {
        $json = $this->call('GET', "/contacts/{$id}.json");
        return $json;
    }

    public function search($query)
    {
        $json = $this->call('GET', "/contacts/search.json?q={$query}");
        return $json;
    }

    public function update($id, $properties)
    {
        $json = $this->call('PUT', "/contacts/{$id}.json", $properties);
        return $json;
    }



    public function getContactById($id)
    {
        return $this->get($id);
    }

    public function addContact($properties)
    {
        return $this->add($properties);
    }

    public function deleteContactById($id)
    {
        return $this->delete($id);
    }

    public function updateContactById($id, $properties)
    {
        return $this->update($id, $properties);
    }

    public function searchContacts($query)
    {
        return $this->search($query);
    }
}
