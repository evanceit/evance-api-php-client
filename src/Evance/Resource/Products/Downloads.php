<?php

namespace Evance\Resource\Products;

use Evance\AbstractResource;
use Evance\ApiClient;

class Downloads extends AbstractResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    public function getOne($productId, $downloadId)
    {
        $this->notImplementedV2('Products\\Downloads', __METHOD__);
    }

    public function getMany($productId, array $params = [])
    {
        $this->notImplementedV2('Products\\Downloads', __METHOD__);
    }

    public function postOne($productId, array $body)
    {
        $this->notImplementedV2('Products\\Downloads', __METHOD__);
    }

    public function putOne($productId, $downloadId, array $body)
    {
        $this->notImplementedV2('Products\\Downloads', __METHOD__);
    }

    public function deleteOne($productId, $downloadId)
    {
        $this->notImplementedV2('Products\\Downloads', __METHOD__);
    }
}
