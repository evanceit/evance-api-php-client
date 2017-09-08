<?php

namespace Evance\Resource;

use Evance\App;
use Evance\Resource;

class Welcome extends Resource
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