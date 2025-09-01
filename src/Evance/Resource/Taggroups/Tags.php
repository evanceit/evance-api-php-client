<?php

namespace Evance\Resource\Taggroups;

use Evance\AbstractResource;
use Evance\ApiClient;

class Tags extends AbstractResource
{
    /**
     * @var int|null
     */
    public ?int $taggroupId;

    public function __construct(ApiClient $client, ?int $taggroupId = null)
    {
        parent::__construct($client);
        $this->taggroupId = $taggroupId;
    }

    public function getOne($tagId, ?int $taggroupId = null)
    {
        $taggroupId = $taggroupId ?? $this->taggroupId;
        if (!$taggroupId) {
            throw new \invalidArgumentException('taggroupId is required');
        }
        $this->notImplementedV2('Taggroups\\Tags', __METHOD__);
    }

    public function getMany(array $params = [], ?int $taggroupId = null)
    {
        $taggroupId = $taggroupId ?? $this->taggroupId;
        if (!$taggroupId) {
            throw new \invalidArgumentException('taggroupId is required');
        }
        $this->notImplementedV2('Taggroups\\Tags', __METHOD__);
    }

    public function postOne(array $body, ?int $taggroupId = null)
    {
        $taggroupId = $taggroupId ?? $this->taggroupId;
        if (!$taggroupId) {
            throw new \invalidArgumentException('taggroupId is required');
        }
        $this->notImplementedV2('Taggroups\\Tags', __METHOD__);
    }

    public function putOne($tagId, array $body, ?int $taggroupId = null)
    {
        $taggroupId = $taggroupId ?? $this->taggroupId;
        if (!$taggroupId) {
            throw new \invalidArgumentException('taggroupId is required');
        }
        $this->notImplementedV2('Taggroups\\Tags', __METHOD__);
    }

    public function deleteOne($tagId, ?int $taggroupId = null)
    {
        $taggroupId = $taggroupId ?? $this->taggroupId;
        if (!$taggroupId) {
            throw new \invalidArgumentException('taggroupId is required');
        }
        $this->notImplementedV2('Taggroups\\Tags', __METHOD__);
    }
}
