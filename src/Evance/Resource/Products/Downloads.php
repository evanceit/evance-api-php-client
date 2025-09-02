<?php

namespace Evance\Resource\Products;

use Evance\AbstractChildResource;
use Evance\ApiClient;
use invalidArgumentException;

class Downloads extends AbstractChildResource
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
     * @param int|null $parentId
     * @return void
     */
    public function getOne($id, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);

        $this->notImplementedV2('Products\\Downloads', __METHOD__);
    }

    /**
     * @param array $params
     * @param int|null $parentId
     * @return void
     */
    public function getMany(array $params = [], ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);

        $this->notImplementedV2('Products\\Downloads', __METHOD__);
    }

    /**
     * @param array $body
     * @param int|null $parentId
     * @return void
     */
    public function postOne(array $body, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);

        $this->notImplementedV2('Products\\Downloads', __METHOD__);
    }

    /**
     * @param $id
     * @param array $body
     * @param int|null $parentId
     * @return void
     */
    public function putOne($id, array $body, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);

        $this->notImplementedV2('Products\\Downloads', __METHOD__);
    }

    /**
     * @param $id
     * @param int|null $parentId
     * @return void
     */
    public function deleteOne($id, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);

        $this->notImplementedV2('Products\\Downloads', __METHOD__);
    }
}
