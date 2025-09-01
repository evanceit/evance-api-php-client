<?php

namespace Evance;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
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
    const DEFAULT_API_VERSION = "";
    const V1 = "";
    const V2 = "v2/";

    /** @var ApiClient */
    private $client;

    /**
     * Resource constructor.
     * @param ApiClient $client The Evance PHP Client to connect to the Resource.
     */
    public function __construct(ApiClient $client)
    {
        $this->version = self::DEFAULT_API_VERSION;
        $this->client = $client;
    }

    /**
     * @param string $httpVerb  A GET, POST, PUT or DELETE Http verb.
     * @param string $url The Url of the API endpoint.
     * @param array|null $body Optional array of body data to send to the API endpoint.
     * @param array|null $params Optional array of parameters to send to the API endpoint.
     * @return mixed
     */
    public function call($httpVerb, $url, $body = null, $params = null)
    {
        Assert::oneOf($httpVerb, ['GET', 'POST', 'PUT', 'DELETE'], __METHOD__ . " encountered an unexpected HTTP verb '{$httpVerb}'");
        Assert::nullOrIsArray($params, __METHOD__ . ' expects call parameters to be null or an array');
        Assert::nullOrIsArray($body, __METHOD__ . ' expects call body to be null or an array');
        Assert::string($url, __METHOD__ . ' expects the $url to be provided as a string');

        $uri = $this->client->getResourceUri($url);
        $request = new Request(
            $httpVerb,
            $uri,
            ['content-type' => 'application/json'],
            $body ? json_encode($body) : ''
        );
        // We had to catch and re throw the client exception to get the full error message
        // otherwise it was being truncated and the Evance save error message was lost.
        try {
            return $this->client->execute($request, $params);
        } catch (ClientException $e) {
            throw new ClientException($e->getResponse()->getBody()->getContents(), $request);
        }
    }

    /**
     * @return ApiClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param $properties
     * @return mixed
     */
    // New canonical method names
    public function getOne($id)
    {
        throw new \RuntimeException(__METHOD__ . " not implemented for this resource");
    }

    public function getMany(array $params = [])
    {
        throw new \RuntimeException(__METHOD__ . " not implemented for this resource");
    }

    public function postOne(array $body)
    {
        throw new \RuntimeException(__METHOD__ . " not implemented for this resource");
    }

    public function putOne($id, array $body)
    {
        throw new \RuntimeException(__METHOD__ . " not implemented for this resource");
    }

    public function deleteOne($id)
    {
        throw new \RuntimeException(__METHOD__ . " not implemented for this resource");
    }

    // Legacy methods kept for BC with deprecation notices
    /**
     * @deprecated Use getOne($id) instead
     */
    public function get($id)
    {
        @trigger_error(__METHOD__ . ' is deprecated. Use getOne($id) instead.', E_USER_DEPRECATED);
        return $this->getOne($id);
    }

    /**
     * @deprecated Use getMany($params) instead. Some resources may also support more specific list/search helpers.
     */
    public function search($params)
    {
        @trigger_error(__METHOD__ . ' is deprecated. Use getMany($params) instead.', E_USER_DEPRECATED);
        return $this->getMany($params);
    }

    /**
     * @deprecated Use getMany($params) instead.
     */
    public function list($params = [])
    {
        @trigger_error(__METHOD__ . ' is deprecated. Use getMany($params) instead.', E_USER_DEPRECATED);
        return $this->getMany($params);
    }

    /**
     * @deprecated Use postOne($body) instead
     */
    public function add($properties)
    {
        @trigger_error(__METHOD__ . ' is deprecated. Use postOne($body) instead.', E_USER_DEPRECATED);
        return $this->postOne($properties);
    }

    /**
     * @deprecated Use putOne($id, $body) instead
     */
    public function update($id, $properties)
    {
        @trigger_error(__METHOD__ . ' is deprecated. Use putOne($id, $body) instead.', E_USER_DEPRECATED);
        return $this->putOne($id, $properties);
    }

    /**
     * @deprecated Use deleteOne($id) instead
     */
    public function delete($id)
    {
        @trigger_error(__METHOD__ . ' is deprecated. Use deleteOne($id) instead.', E_USER_DEPRECATED);
        return $this->deleteOne($id);
    }

    /**
     * @param string $version
     * @return void
     */
    public function setVersion(string $version) {
        $this->version = $version;
    }


}