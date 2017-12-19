<?php

namespace Evance\Resource;

use Evance\App;
use Evance\AbstractResource;

class Welcome extends AbstractResource
{
    public function __construct(App $client)
    {
        parent::__construct($client);
    }

    public function message()
    {
        $json = $this->call('GET', '/index.json');
        return $json['message'];
    }
}