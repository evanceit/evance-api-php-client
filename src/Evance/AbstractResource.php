<?php

namespace Evance;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
use RuntimeException;
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
    private ApiClient $client;

    /**
     * Current API version prefix used when building URLs ('' for v1, 'v2/' for v2)
     * @var string
     */
    protected string $version;

    /**
     * Internal map of resource version support to control deprecation notices.
     * Keys are resource identifiers (e.g. 'Products', 'Products\\Prices').
     */
    private static $resourceVersionSupport = [
        // Existing resources
        'Branches' => ['v1' => true, 'v2' => false],
        'Categories' => ['v1' => true, 'v2' => true],
        'Contacts' => ['v1' => true, 'v2' => true],
        'Pages' => ['v1' => true, 'v2' => true],
        'Downloads' => ['v1' => false, 'v2' => true],
        'Inventory' => ['v1' => false, 'v2' => true],
        'Locations' => ['v1' => false, 'v2' => true],
        'ProductMedia' => ['v1' => true, 'v2' => false],
        'Products' => ['v1' => true, 'v2' => true],
        'ProductSpecification' => ['v1' => true, 'v2' => false],
        'ProductTranslations' => ['v1' => true, 'v2' => false],
        'Webhooks' => ['v1' => false, 'v2' => true],
        'Welcome' => ['v1' => true, 'v2' => true],
        // New V2 stubs (not yet implemented)
        'Geozones' => ['v1' => false, 'v2' => true],
        'Giftcards' => ['v1' => false, 'v2' => true],
        'Redirects' => ['v1' => false, 'v2' => true],
        'Roles' => ['v1' => false, 'v2' => true],
        'Specifications' => ['v1' => false, 'v2' => true],
        'Taggroups' => ['v1' => false, 'v2' => true],
        'Categories\\Entries' => ['v1' => false, 'v2' => true],
        'Contacts\\Addresses' => ['v1' => false, 'v2' => true],
        'Contacts\\Roles' => ['v1' => false, 'v2' => true],
        'Products\\Downloads' => ['v1' => false, 'v2' => true],
        'Products\\Media' => ['v1' => false, 'v2' => true],
        'Products\\Prices' => ['v1' => false, 'v2' => true],
        'Products\\Specifications' => ['v1' => false, 'v2' => true],
        'Specifications\\Values' => ['v1' => false, 'v2' => true],
        'Taggroups\\Tags' => ['v1' => false, 'v2' => true],
    ];

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

        // Emit deprecation notices for legacy v1 usage when applicable
        $this->maybeWarnForDeprecatedVersionUsage();

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


    // New canonical method names
    public function getOne($id)
    {
        throw new RuntimeException(__METHOD__ . " not implemented for this resource");
    }

    public function getMany(array $params = [])
    {
        throw new RuntimeException(__METHOD__ . " not implemented for this resource");
    }

    public function postOne(array $body)
    {
        throw new RuntimeException(__METHOD__ . " not implemented for this resource");
    }

    public function putOne($id, array $body)
    {
        throw new RuntimeException(__METHOD__ . " not implemented for this resource");
    }

    public function deleteOne($id)
    {
        throw new RuntimeException(__METHOD__ . " not implemented for this resource");
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
    public function search($query)
    {
        @trigger_error(__METHOD__ . ' is deprecated. Use getMany($params) instead.', E_USER_DEPRECATED);
        return $this->getMany(['q' => $query]);
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

    /**
     * Determine if we should emit a deprecation warning based on the resource and version.
     */
    protected function maybeWarnForDeprecatedVersionUsage(): void
    {
        // V2 or unspecified resource mapping – do nothing
        if ($this->version === self::V2) {
            return;
        } else {
            // Resolve resource identifier relative to Evance\Resource namespace
            $fqcn = get_class($this);
            $prefix = 'Evance\\Resource\\';
            $resourceKey = strpos($fqcn, $prefix) === 0 ? substr($fqcn, strlen($prefix)) : $fqcn;
            if (!isset(self::$resourceVersionSupport[$resourceKey])) {
                return;
            }
            $support = self::$resourceVersionSupport[$resourceKey];
            if (!empty($support['v1']) && !empty($support['v2'])) {
                @trigger_error($resourceKey . ' v1 is deprecated. Consider using v2 for this resource. The call will proceed using v1.', E_USER_DEPRECATED);
                return;
            }
            // If resource only exists in v1, warn deprecated but no alternative
            if (!empty($support['v1']) && empty($support['v2'])) {
                @trigger_error($resourceKey . ' uses legacy v1 and is deprecated. No v2 alternative is available yet. The call will proceed.', E_USER_DEPRECATED);
            }
        }
    }

    /**
     * Helper for V2 placeholders not yet implemented in this client.
     * Always triggers a warning and throws to avoid accidental network calls.
     */
    protected function notImplementedV2(string $resource, string $method): void
    {
        @trigger_error($resource . ' (v2) is not implemented in this PHP client yet. Method: ' . $method, E_USER_WARNING);
        throw new RuntimeException($resource . ' (v2) not implemented: ' . $method);
    }

}