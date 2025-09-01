<?php

namespace Evance\Resource\Contacts;

use Evance\AbstractResource;
use Evance\ApiClient;

class Roles extends AbstractResource
{
    /**
     * @var int|null
     */
    public ?int $contactId;

    public function __construct(ApiClient $client, $contactId = null)
    {
        parent::__construct($client);
        $this->contactId = $contactId;
    }

    /**
     * @param $roleId
     * @param $contactId
     * @return void
     */
    public function getOne($roleId, $contactId = null)
    {
        $contactId = $contactId ?? $this->contactId;
        if (!$contactId) {
            throw new \invalidArgumentException('contactId is required');
        }
        $this->notImplementedV2('Contacts\\Roles', __METHOD__);
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

        $this->notImplementedV2('Contacts\\Roles', __METHOD__);
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

        $this->notImplementedV2('Contacts\\Roles', __METHOD__);
    }

    /**
     * @param $roleId
     * @param array $body
     * @param $contactId
     * @return void
     */
    public function putOne($roleId, array $body, $contactId= null)
    {
        $contactId = $contactId ?? $this->contactId;
        if (!$contactId) {
            throw new \invalidArgumentException('contactId is required');
        }

        $this->notImplementedV2('Contacts\\Roles', __METHOD__);
    }

    /**
     * @param $roleId
     * @param $contactId
     * @return void
     */
    public function deleteOne($roleId, $contactId= null)
    {
        $contactId = $contactId ?? $this->contactId;
        if (!$contactId) {
            throw new \invalidArgumentException('contactId is required');
        }

        $this->notImplementedV2('Contacts\\Roles', __METHOD__);
    }
}
