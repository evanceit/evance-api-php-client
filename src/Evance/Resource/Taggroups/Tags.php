<?php

namespace Evance\Resource\Taggroups;

use Evance\AbstractChildResource;
use Evance\ApiClient;
use invalidArgumentException;

class Tags extends AbstractChildResource
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

    public function getOne($id, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        $this->notImplementedV2('Taggroups\\Tags', __METHOD__);
    }

    public function getMany(array $params = [], ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        $this->notImplementedV2('Taggroups\\Tags', __METHOD__);
    }

    public function postOne(array $body, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        $this->notImplementedV2('Taggroups\\Tags', __METHOD__);
    }

    public function putOne($id, array $body, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        $this->notImplementedV2('Taggroups\\Tags', __METHOD__);
    }

    public function deleteOne($id, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        $this->notImplementedV2('Taggroups\\Tags', __METHOD__);
    }
}
