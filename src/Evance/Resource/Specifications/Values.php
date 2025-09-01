<?php

namespace Evance\Resource\Specifications;

use Evance\AbstractResource;
use Evance\ApiClient;

class Values extends AbstractResource
{
    /**
     * @var int|null
     */
    public ?int $specificationId;

    public function __construct(ApiClient $client, ?int $specificationId = null)
    {
        parent::__construct($client);
        $this->specificationId = $specificationId;
    }

    public function getOne($valueId, ?int $specificationId = null)
    {
        $specificationId = $specificationId ?? $this->specificationId;
        if (!$specificationId) {
            throw new \invalidArgumentException('specificationId is required');
        }
        $this->notImplementedV2('Specifications\\Values', __METHOD__);
    }

    public function getMany(array $params = [], ?int $specificationId = null)
    {
        $specificationId = $specificationId ?? $this->specificationId;
        if (!$specificationId) {
            throw new \invalidArgumentException('specificationId is required');
        }
        $this->notImplementedV2('Specifications\\Values', __METHOD__);
    }

    public function postOne(array $body, ?int $specificationId = null)
    {
        $specificationId = $specificationId ?? $this->specificationId;
        if (!$specificationId) {
            throw new \invalidArgumentException('specificationId is required');
        }
        $this->notImplementedV2('Specifications\\Values', __METHOD__);
    }

    public function putOne($valueId, array $body, ?int $specificationId = null)
    {
        $specificationId = $specificationId ?? $this->specificationId;
        if (!$specificationId) {
            throw new \invalidArgumentException('specificationId is required');
        }
        $this->notImplementedV2('Specifications\\Values', __METHOD__);
    }

    public function deleteOne($valueId, ?int $specificationId = null)
    {
        $specificationId = $specificationId ?? $this->specificationId;
        if (!$specificationId) {
            throw new \invalidArgumentException('specificationId is required');
        }
        $this->notImplementedV2('Specifications\\Values', __METHOD__);
    }
}
