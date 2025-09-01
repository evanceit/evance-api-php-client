<?php

namespace Evance\Resource\Contacts;

use Evance\AbstractResource;
use Evance\ApiClient;

class Addresses extends AbstractResource
{
    /**
     * @var int|null
     */
    public ?int $contactId;

    public function __construct(ApiClient $client, $contactId= null)
    {
        parent::__construct($client);
        $this->contactId = $contactId;
    }

    /**
     * @param $addressId
     * @param $contactId
     * @return void
     */
    public function getOne($addressId, $contactId= null)
    {
        $contactId = $contactId ?? $this->contactId;
        if (!$contactId) {
            throw new \invalidArgumentException('contactId is required');
        }
        $this->notImplementedV2('Contacts\\Addresses', __METHOD__);
    }

    /**
     * @param array $params
     * @param $contactId
     * @return void
     */
    public function getMany(array $params = [], $contactId= null)
    {
        $contactId = $contactId ?? $this->contactId;
        if (!$contactId) {
            throw new \invalidArgumentException('contactId is required');
        }

        $this->notImplementedV2('Contacts\\Addresses', __METHOD__);
    }

    /**
     * @param array $body
     * @param $contactId
     * @return void
     */
    public function postOne(array $body, $contactId= null)
    {
        $contactId = $contactId ?? $this->contactId;
        if (!$contactId) {
            throw new \invalidArgumentException('contactId is required');
        }

        $this->notImplementedV2('Contacts\\Addresses', __METHOD__);
    }

    /**
     * @param $addressId
     * @param array $body
     * @param $contactId
     * @return void
     */
    public function putOne($addressId, array $body, $contactId= null)
    {
        $contactId = $contactId ?? $this->contactId;
        if (!$contactId) {
            throw new \invalidArgumentException('contactId is required');
        }

        $this->notImplementedV2('Contacts\\Addresses', __METHOD__);
    }

    /**
     * @param $addressId
     * @param $contactId
     * @return void
     */
    public function deleteOne($addressId, $contactId= null)
    {
        $contactId = $contactId ?? $this->contactId;
        if (!$contactId) {
            throw new \invalidArgumentException('contactId is required');
        }
        $this->notImplementedV2('Contacts\\Addresses', __METHOD__);
    }
}
