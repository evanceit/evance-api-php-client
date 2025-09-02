<?php

namespace Evance\Resource\Categories;

use Evance\AbstractChildResource;
use Evance\ApiClient;
use invalidArgumentException;

class Entries extends AbstractChildResource
{
    /**
     * @var int|null
     */
    public ?int $parentId;

    public function __construct(ApiClient $client, $parentId = null)
    {
        parent::__construct($client);
        $this->parentId = $parentId;
    }

    /**
     * @param $id
     * @param $parentId
     * @return void
     */
    public function getOne($id, $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);

        $this->notImplementedV2('Categories\\Entries', __METHOD__);
    }

    /**
     * @param array $params
     * @param $parentId
     * @return void
     */
    public function getMany(array $params = [], $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);

        $this->notImplementedV2('Categories\\Entries', __METHOD__);
    }

    /**
     * @param array $body
     * @param $parentId
     * @return void
     */
    public function postOne(array $body, $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);

        $this->notImplementedV2('Categories\\Entries', __METHOD__);
    }

    /**
     * @param $id
     * @param array $body
     * @param $parentId
     * @return void
     */
    public function putOne($id, array $body, $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);

        $this->notImplementedV2('Categories\\Entries', __METHOD__);
    }

    /**
     * @param $id
     * @param $parentId
     * @return void
     */
    public function deleteOne($id, $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);

        $this->notImplementedV2('Categories\\Entries', __METHOD__);
    }
}
