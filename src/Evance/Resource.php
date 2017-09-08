<?php

namespace Evance;

use GuzzleHttp\Psr7\Request;

class Resource{

    private $client;

    public function __construct(App $client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function call($httpVerb, $url, $params=null){

        $uri = $this->getClient()->getResourceUri($url);

        $request = new Request(
            $httpVerb,
            $uri,
            ['content-type' => 'application/json'],
            $params ? json_encode($params) : ''
        );

        return $this->client->execute($request);
    }
}