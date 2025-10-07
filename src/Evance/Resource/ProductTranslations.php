<?php

namespace Evance\Resource;

use Evance\AbstractChildResource;
use Evance\ApiClient;
use Webmozart\Assert\Assert;

/**
 * @deprecated will be replaced by Products/Translations
 */
class ProductTranslations extends AbstractChildResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    public function getMany(array $params = [], $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        Assert::integerish($parentId, __METHOD__ . ' expects a $productId as an integer');
        Assert::isArray($params, __METHOD__ . ' expects $params to be an array of key value pairs');
        return $this->call('GET', "/products/{$parentId}/translations.json", [], $params);
    }

    public function getLocales($productId)
    {
        Assert::integerish($productId, __METHOD__ . ' expects a $productId as an integer');
        return $this->call('GET', "/products/{$productId}/locales.json");
    }

    public function postOne(array $body = [], $parentId = null)
    {
        $productId = $this->requireParentId($parentId);
        Assert::integerish($parentId, __METHOD__ . ' expects an $parentId as an integer');
        Assert::isArray($body, __METHOD__ . ' expects $translations to be supplied as an array');
        Assert::keyExists($body, "translation",  __METHOD__ . ' expects $translations to contain key of "translation"' .
            ' with value of object or array');
        return $this->call('POST', "/products/{$parentId}/translations.json", $body);
    }

    public function getById($productId, $translationsId)
    {
        return $this->getOne($translationsId, $productId);
    }
    public function getOne($id, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        Assert::integerish($parentId, __METHOD__ . ' expects an $parenttId as an integer');
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('GET', "/products/{$parentId}/translations/{$id}.json");
    }

    public function putOne($id, $body, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        Assert::integerish($parentId, __METHOD__ . ' expects an $parentId as an integer');
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        Assert::isArray($body, __METHOD__ . ' expects $body to be supplied as an array');
        Assert::keyExists($body, "translation",  __METHOD__ . ' expects $translations to contain key of "translation"' .
            ' with value of object or array');
        return $this->call('PUT', "/products/{$parentId}/translations/{$id}.json", $body);
    }

    public function deleteOne($id, ?int $parentId = null)
    {
        $parentId = $this->requireParentId($parentId);
        Assert::integerish($parentId, __METHOD__ . ' expects an $parentId as an integer');
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('DELETE', "/products/{$parentId}/translations/{$id}.json");
    }
}
