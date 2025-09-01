<?php

namespace Evance\Resource;

use Evance\AbstractResource;
use Evance\ApiClient;

class Giftcards extends AbstractResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    public function getOne($id)
    {
        $this->notImplementedV2('Giftcards', __METHOD__);
    }

    public function getMany(array $params = [])
    {
        $this->notImplementedV2('Giftcards', __METHOD__);
    }

    public function postOne(array $body)
    {
        $this->notImplementedV2('Giftcards', __METHOD__);
    }

    public function putOne($id, array $body)
    {
        $this->notImplementedV2('Giftcards', __METHOD__);
    }

    public function deleteOne($id)
    {
        $this->notImplementedV2('Giftcards', __METHOD__);
    }
}
