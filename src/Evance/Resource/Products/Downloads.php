<?php

namespace Evance\Resource\Products;

use Evance\AbstractResource;
use Evance\ApiClient;

class Downloads extends AbstractResource
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

    /**
     * @param $downloadId
     * @param int|null $productId
     * @return void
     */
    public function getOne($downloadId, ?int $productId = null)
    {
        $productId = $productId ?? $this->productId;
        if (!$productId) {
            throw new \invalidArgumentException('productId is required');
        }

        $this->notImplementedV2('Products\\Downloads', __METHOD__);
    }

    /**
     * @param array $params
     * @param int|null $productId
     * @return void
     */
    public function getMany(array $params = [], ?int $productId = null)
    {
        $productId = $productId ?? $this->productId;
        if (!$productId) {
            throw new \invalidArgumentException('productId is required');
        }

        $this->notImplementedV2('Products\\Downloads', __METHOD__);
    }

    /**
     * @param array $body
     * @param int|null $productId
     * @return void
     */
    public function postOne(array $body, ?int $productId = null)
    {
        $productId = $productId ?? $this->productId;
        if (!$productId) {
            throw new \invalidArgumentException('productId is required');
        }

        $this->notImplementedV2('Products\\Downloads', __METHOD__);
    }

    /**
     * @param $downloadId
     * @param array $body
     * @param int|null $productId
     * @return void
     */
    public function putOne($downloadId, array $body, ?int $productId = null)
    {
        $productId = $productId ?? $this->productId;
        if (!$productId) {
            throw new \invalidArgumentException('productId is required');
        }

        $this->notImplementedV2('Products\\Downloads', __METHOD__);
    }

    /**
     * @param $downloadId
     * @param int|null $productId
     * @return void
     */
    public function deleteOne($downloadId, ?int $productId = null)
    {
        $productId = $productId ?? $this->productId;
        if (!$productId) {
            throw new \invalidArgumentException('productId is required');
        }

        $this->notImplementedV2('Products\\Downloads', __METHOD__);
    }
}
