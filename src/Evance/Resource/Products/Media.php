<?php

namespace Evance\Resource\Products;

use Evance\AbstractResource;
use Evance\ApiClient;

class Media extends AbstractResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    public function getOne($productId, $mediaId)
    {
        $this->notImplementedV2('Products\\Media', __METHOD__);
    }

    public function getMany($productId, array $params = [])
    {
        $this->notImplementedV2('Products\\Media', __METHOD__);
    }

    public function postOne($productId, array $body)
    {
        $this->notImplementedV2('Products\\Media', __METHOD__);
    }

    public function putOne($productId, $mediaId, array $body)
    {
        $this->notImplementedV2('Products\\Media', __METHOD__);
    }

    public function deleteOne($productId, $mediaId)
    {
        $this->notImplementedV2('Products\\Media', __METHOD__);
    }
}
