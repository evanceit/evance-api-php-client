<?php

namespace Evance\Resource\Products;

use Evance\AbstractResource;
use Evance\ApiClient;

class Media extends AbstractResource
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
     * @param $mediaId
     * @param int|null $productId
     * @return void
     */
    public function getOne($mediaId, ?int $productId = null)
    {
        $productId = $productId ?? $this->productId;
        if (!$productId) {
            throw new \invalidArgumentException('productId is required');
        }

        $this->notImplementedV2('Products\\Media', __METHOD__);
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

        $this->notImplementedV2('Products\\Media', __METHOD__);
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

        $this->notImplementedV2('Products\\Media', __METHOD__);
    }

    /**
     * @param $mediaId
     * @param array $body
     * @param int|null $productId
     * @return void
     */
    public function putOne($mediaId, array $body, ?int $productId = null)
    {
        $productId = $productId ?? $this->productId;
        if (!$productId) {
            throw new \invalidArgumentException('productId is required');
        }

        $this->notImplementedV2('Products\\Media', __METHOD__);
    }

    /**
     * @param $mediaId
     * @param int|null $productId
     * @return void
     */
    public function deleteOne($mediaId, ?int $productId = null)
    {
        $productId = $productId ?? $this->productId;
        if (!$productId) {
            throw new \invalidArgumentException('productId is required');
        }

        $this->notImplementedV2('Products\\Media', __METHOD__);
    }
}
