<?php

namespace Evance\Resource\Contacts;

use Evance\AbstractResource;
use Evance\ApiClient;

class Roles extends AbstractResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    public function getOne($contactId, $roleId)
    {
        $this->notImplementedV2('Contacts\\Roles', __METHOD__);
    }

    public function getMany($contactId, array $params = [])
    {
        $this->notImplementedV2('Contacts\\Roles', __METHOD__);
    }

    public function postOne($contactId, array $body)
    {
        $this->notImplementedV2('Contacts\\Roles', __METHOD__);
    }

    public function putOne($contactId, $roleId, array $body)
    {
        $this->notImplementedV2('Contacts\\Roles', __METHOD__);
    }

    public function deleteOne($contactId, $roleId)
    {
        $this->notImplementedV2('Contacts\\Roles', __METHOD__);
    }
}
