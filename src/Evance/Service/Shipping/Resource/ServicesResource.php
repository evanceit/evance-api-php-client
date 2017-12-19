<?php

namespace Evance\Service\Shipping\Resource;

use Evance\AbstractResource;
use Webmozart\Assert\Assert;

/**
 * The Shipping Service resource class is a direct representation of the API endpoint.
 * If you do not wish to use our
 * @package Evance\Service\Shipping\Resource
 */
class ServicesResource extends AbstractResource
{

    /**
     * Create/register a Shipping Service for the App.
     * When creating a Shipping Service the service will automatically be associated with the App.
     * @param array $properties The properties to send to the API.
     * @return array
     */
    public function add($properties)
    {
        Assert::isArray($properties, __METHOD__ . ' expects $properties to be supplied as an array');
        if (!array_key_exists('shippingService', $properties)) {
            throw new \InvalidArgumentException(__METHOD__ . ' expected a "shippingService" property');
        }
        return $this->call('POST', '/shipping/services.json', $properties);
    }

    /**
     * Delete a Shipping Service for the App.
     * Note: you can only delete a Shipping Service if the App is the owner of the service.
     * @param int $id The ID of the Shipping Service.
     * @return array
     */
    public function delete($id)
    {
        Assert::integerish($id, __METHOD__ . 'expects $id to be an integer');
        return $this->call('DELETE', "/shipping/services/{$id}.json");
    }

    /**
     * Get a Shipping Service for the App.
     * Note: you may only GET Shipping Service information for services owned by the App.
     * @param int $id The ID of the Shipping Service.
     * @return array
     */
    public function get($id)
    {
        Assert::integerish($id, __METHOD__ . ' expects $id to be an integer');
        return $this->call('GET', "/shipping/services/{$id}.json");
    }

    /**
     * Get a list of Shipping Services associated with this App.
     * @return array
     */
    public function getList()
    {
        return $this->call('GET', "/shipping/services.json");
    }

    /**
     * Update a Shipping Service for the App.
     * Note: an App may only update a Shipping Service that it owns.
     * @param int $id The ID of the Shipping Service.
     * @param array $properties The properties to update.
     * @return array
     */
    public function update($id, $properties)
    {
        Assert::integerish($id, __METHOD__ . ' expects $id to be an integer');
        Assert::isArray($properties, __METHOD__ . ' expects $properties to be supplied as an array');
        if (!array_key_exists('shippingService', $properties)) {
            throw new \InvalidArgumentException(__METHOD__ . ' expected a "shippingService" property');
        }
        return $this->call('PUT', "/shipping/services/{$id}.json", $properties);
    }

}