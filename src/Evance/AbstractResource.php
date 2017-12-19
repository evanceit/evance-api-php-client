<?php

namespace Evance;

use GuzzleHttp\Psr7\Request;
use Webmozart\Assert\Assert;

/**
 * A Resource Class is designed to be a literal representation of an API endpoint.
 * It does pretty much no mutations on data expected by, or returned by, an endpoint
 * other than that data is represented as an associate array in both directions.
 *
 * This literal representation is done on purpose - it allows developers to
 * completely ignore our Service classes in favour of implementing their own classes.
 * Consequently, with the exception of requiring our PHP client, the Resource classes
 * are lightweight and "standalone".
 *
 * @package Evance
 */
abstract class AbstractResource
{
    /** @var App */
    private $client;

    /**
     * Resource constructor.
     * @param App $client The Evance PHP Client to connect to the Resource.
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

    /**
     * @return App
     */
    public function getClient()
    {
        return $this->client;
    }

    abstract public function add($properties);

    abstract public function delete($id);

    abstract public function get($id);

    abstract public function update($id, $properties);



}