<?php

namespace Evance;

use GuzzleHttp\Psr7\Request;
use Webmozart\Assert\Assert;

/**
 * Class Resource
 * @package Evance
 */
class Resource
{
    /** @var App */
    private $client;

    /**
     * Resource constructor.
     * @param App $client
     */
    public function __construct(App $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $httpVerb  A GET, POST, PUT or DELETE Http verb.
     * @param string $url The Url of the API endpoint.
     * @param array|null $params Optional array of parameters to send to the API endpoint.
     * @return mixed
     */
    public function call($httpVerb, $url, $params = null)
    {
        Assert::oneOf($httpVerb, ['GET', 'POST', 'PUT', 'DELETE'], __METHOD__ . " encountered an unexpected HTTP verb '{$httpVerb}'");
        Assert::nullOrIsArray($params, __METHOD__ . ' expects call parameters to be null or an array');
        Assert::string($url, __METHOD__ . ' expects the $url to be provided as a string');

        $uri = $this->client->getResourceUri($url);
        $request = new Request(
            $httpVerb,
            $uri,
            ['content-type' => 'application/json'],
            $params ? json_encode($params) : ''
        );
        return $this->client->execute($request);
    }

}