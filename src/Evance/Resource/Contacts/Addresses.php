<?php

namespace Evance\Resource\Contacts;

use Evance\AbstractResource;
use Evance\ApiClient;

class Addresses extends AbstractResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    public function getOne($contactId, $addressId)
    {
        $this->notImplementedV2('Contacts\\Addresses', __METHOD__);
    }

    public function getMany($contactId, array $params = [])
    {
        $this->notImplementedV2('Contacts\\Addresses', __METHOD__);
    }

    public function postOne($contactId, array $body)
    {
        $this->notImplementedV2('Contacts\\Addresses', __METHOD__);
    }

    public function putOne($contactId, $addressId, array $body)
    {
        $this->notImplementedV2('Contacts\\Addresses', __METHOD__);
    }

    public function deleteOne($contactId, $addressId)
    {
        $this->notImplementedV2('Contacts\\Addresses', __METHOD__);
    }
}
