<?php

namespace Evance\Resource\Products;

use Evance\AbstractResource;
use Evance\ApiClient;

class Prices extends AbstractResource
{
    /**
     * @var int|null
     */
    public ?int $productId;

    public function __construct(ApiClient $client, ?int $productId = null)
    {
        parent::__construct($client);
        $this->productId = $productId;
    }

    public function getOne($priceId, ?int $productId = null)
    {
        $productId = $productId ?? $this->productId;
        if (!$productId) {
            throw new \invalidArgumentException('productId is required');
        }
        $this->notImplementedV2('Products\\Prices', __METHOD__);
    }

    public function getMany(array $params = [], ?int $productId = null)
    {
        $productId = $productId ?? $this->productId;
        if (!$productId) {
            throw new \invalidArgumentException('productId is required');
        }
        $this->notImplementedV2('Products\\Prices', __METHOD__);
    }

    public function postOne(array $body, ?int $productId = null)
    {
        $productId = $productId ?? $this->productId;
        if (!$productId) {
            throw new \invalidArgumentException('productId is required');
        }
        $this->notImplementedV2('Products\\Prices', __METHOD__);
    }

    public function putOne($priceId, array $body, ?int $productId = null)
    {
        $productId = $productId ?? $this->productId;
        if (!$productId) {
            throw new \invalidArgumentException('productId is required');
        }
        $this->notImplementedV2('Products\\Prices', __METHOD__);
    }

    public function deleteOne($priceId, ?int $productId = null)
    {
        $productId = $productId ?? $this->productId;
        if (!$productId) {
            throw new \invalidArgumentException('productId is required');
        }
        $this->notImplementedV2('Products\\Prices', __METHOD__);
    }
}
