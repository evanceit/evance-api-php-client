<?php

namespace Evance\Resource;

use Evance\ApiClient;
use Evance\AbstractResource;

class Welcome extends AbstractResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    public function message()
    {
        $json = $this->call('GET', '/index.json');
        return $json['message'];
    }
}