<?php

namespace Evance\Resource\Contacts;

use Evance\AbstractChildResource;
use Evance\ApiClient;
use invalidArgumentException;

class Roles extends AbstractChildResource
{
    /**
     * @var int|null
     */
    public ?int $parentId;

    public function __construct(ApiClient $client, ?int $parentId = null)
    {
        parent::__construct($client);
        $this->parentId = $parentId;
    }

    /**
     * @param $id
     * @param null $parentId
     * @return void
     */
    public function getOne($id, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        $this->notImplementedV2('Contacts\\Roles', __METHOD__);
    }

    /**
     * @param array $params
     * @param $parentId
     * @return void
     */
    public function getMany(array $params = [], ?int $parentId= null)
    {
        $parentId = $this->requireParentId($parentId);

        $this->notImplementedV2('Contacts\\Roles', __METHOD__);
    }

    /**
     * @param array $body
     * @param $parentId
     * @return void
     */
    public function postOne(array $body, ?int $parentId= null)
    {
        $parentId = $this->requireParentId($parentId);

        $this->notImplementedV2('Contacts\\Roles', __METHOD__);
    }

    /**
     * @param $id
     * @param array $body
     * @param $parentId
     * @return void
     */
    public function putOne(int $id, array $body, ?int $parentId= null)
    {
        $parentId = $this->requireParentId($parentId);

        $this->notImplementedV2('Contacts\\Roles', __METHOD__);
    }

    /**
     * @param $id
     * @param $parentId
     * @return void
     */
    public function deleteOne(int $id, ?int $parentId= null)
    {
        $parentId = $this->requireParentId($parentId);

        $this->notImplementedV2('Contacts\\Roles', __METHOD__);
    }
}
