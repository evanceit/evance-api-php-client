<?php

namespace Evance\Resource;

use Evance\App;
use Evance\Resource;

class Contacts extends Resource
{
    public function __construct(App $client)
    {
        parent::__construct($client);
    }

    public function getContactById($id=null)
    {
        $json = $this->call('GET', "/contacts/$id.json");
        return $json;
    }

    public function addContact($contactObj)
    {
        $json = $this->call('POST', "/contacts.json", $contactObj);
        return $json;
    }

    public function deleteContactById($id)
    {
        $json = $this->call('DELETE', "/contacts/$id.json");
        return $json;
    }

    public function updateContactById($id, $contactObj)
    {
        $json = $this->call('PUT', "/contacts/$id.json", $contactObj);
        return $json;
    }

    public function searchContacts($query)
    {
        $json = $this->call('GET', "/contacts/search.json?q=$query");
        return $json;
    }
}
