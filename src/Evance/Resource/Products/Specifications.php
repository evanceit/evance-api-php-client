<?php

namespace Evance\Resource\Products;

use Evance\AbstractChildResource;
use Evance\ApiClient;
use invalidArgumentException;

class Specifications extends AbstractChildResource
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
     * @param int $id
     * @param int|null $parentId
     * @return void
     */
    public function getOne(int $id, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        $this->notImplementedV2('Products\\Specifications', __METHOD__);
    }

    /**
     * @param array $params
     * @param int|null $parentId
     * @return void
     */
    public function getMany(array $params = [], ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        $this->notImplementedV2('Products\\Specifications', __METHOD__);
    }

    /**
     * @param array $body
     * @param int|null $parentId
     * @return void
     */
    public function postOne(array $body, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        $this->notImplementedV2('Products\\Specifications', __METHOD__);
    }

    /**
     * @param int $id
     * @param array $body
     * @param int|null $parentId
     * @return void
     */
    public function putOne(int $id, array $body, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        $this->notImplementedV2('Products\\Specifications', __METHOD__);
    }

    /**
     * @param int $id
     * @param int|null $parentId
     * @return void
     */
    public function deleteOne(int $id, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        $this->notImplementedV2('Products\\Specifications', __METHOD__);
    }
}
