<?php

namespace Evance\Resource\Categories;

use Evance\AbstractResource;
use Evance\ApiClient;

class Entries extends AbstractResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    public function getOne($categoryId, $entryId)
    {
        $this->notImplementedV2('Categories\\Entries', __METHOD__);
    }

    public function getMany($categoryId, array $params = [])
    {
        $this->notImplementedV2('Categories\\Entries', __METHOD__);
    }

    public function postOne($categoryId, array $body)
    {
        $this->notImplementedV2('Categories\\Entries', __METHOD__);
    }

    public function putOne($categoryId, $entryId, array $body)
    {
        $this->notImplementedV2('Categories\\Entries', __METHOD__);
    }

    public function deleteOne($categoryId, $entryId)
    {
        $this->notImplementedV2('Categories\\Entries', __METHOD__);
    }
}
