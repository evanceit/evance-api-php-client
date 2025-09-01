<?php

namespace Evance\Resource\Categories;

use Evance\AbstractResource;
use Evance\ApiClient;

class Entries extends AbstractResource
{
    /**
     * @var int|null
     */
    public ?int $categoryId;

    public function __construct(ApiClient $client, $categoryId = null)
    {
        parent::__construct($client);
        $this->categoryId = $categoryId;
    }

    /**
     * @param $entryId
     * @param $categoryId
     * @return void
     */
    public function getOne($entryId, $categoryId = null)
    {
        $categoryId = $categoryId ?? $this->categoryId;
        if (!$categoryId) {
            throw new \invalidArgumentException('categoryId is required');
        }

        $this->notImplementedV2('Categories\\Entries', __METHOD__);
    }

    /**
     * @param array $params
     * @param $categoryId
     * @return void
     */
    public function getMany(array $params = [], $categoryId = null)
    {
        $categoryId = $categoryId ?? $this->categoryId;
        if (!$categoryId) {
            throw new \invalidArgumentException('categoryId is required');
        }

        $this->notImplementedV2('Categories\\Entries', __METHOD__);
    }

    /**
     * @param array $body
     * @param $categoryId
     * @return void
     */
    public function postOne(array $body, $categoryId = null)
    {
        $categoryId = $categoryId ?? $this->categoryId;
        if (!$categoryId) {
            throw new \invalidArgumentException('categoryId is required');
        }

        $this->notImplementedV2('Categories\\Entries', __METHOD__);
    }

    /**
     * @param $entryId
     * @param array $body
     * @param $categoryId
     * @return void
     */
    public function putOne($entryId, array $body, $categoryId = null)
    {
        $categoryId = $categoryId ?? $this->categoryId;
        if (!$categoryId) {
            throw new \invalidArgumentException('categoryId is required');
        }

        $this->notImplementedV2('Categories\\Entries', __METHOD__);
    }

    /**
     * @param $entryId
     * @param $categoryId
     * @return void
     */
    public function deleteOne($entryId, $categoryId = null)
    {
        $categoryId = $categoryId ?? $this->categoryId;
        if (!$categoryId) {
            throw new \invalidArgumentException('categoryId is required');
        }

        $this->notImplementedV2('Categories\\Entries', __METHOD__);
    }
}
