<?php

namespace Evance\Service\Shipping;

use Evance\AbstractService;
use Evance\ApiClient;
use Evance\Literal\Object;
use Evance\Resource\Shipping\Services as ServicesResource;

/**
 * Class Service
 * A service has the following properties:
 *
 * @method string getTitle()
 * @method bool getIsActive()
 * @method string getRatesUlr()
 * @method string getOptionsUrl()
 * @method string getCreated()
 *
 * @method setTitle(string $title)
 * @method setIsActive(bool $value)
 * @method setRatesUrl(string $url)
 * @method setOptionsUrl(string $url)
 *
 * @package Evance\Service\Shipping
 */
class Service extends AbstractService
{

    /**
     * Service constructor.
     * @param ApiClient $client
     * @param array $properties
     */
    public function __construct(ApiClient $client, $properties = [])
    {
        $properties = (new Object([
            'id' => null,
            'title' => '',
            'isActive' => true,
            'ratesUrl' => '',
            'optionsUrl' => '',
            'created' => null
        ]))->merge($properties);
        parent::__construct($client, new ServicesResource($client), 'shippingService',  $properties);
    }

    /**
     * Alias of getIsActive()
     * @return bool
     */
    public function isActive()
    {
        return $this->getIsActive();
    }
}