<?php

namespace Evance\Resource;

use Evance\AbstractResource;
use Evance\ApiClient;

class Taggroups extends AbstractResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    public function getOne(int $id)
    {
        $this->notImplementedV2('Taggroups', __METHOD__);
    }

    public function getMany(array $params = [])
    {
        $this->notImplementedV2('Taggroups', __METHOD__);
    }

    public function postOne(array $body)
    {
        $this->notImplementedV2('Taggroups', __METHOD__);
    }

    public function putOne(int $id, array $body)
    {
        $this->notImplementedV2('Taggroups', __METHOD__);
    }

    public function deleteOne(int $id)
    {
        $this->notImplementedV2('Taggroups', __METHOD__);
    }
}
