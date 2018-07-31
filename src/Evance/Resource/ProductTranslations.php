<?php

namespace Evance\Resource;

use Evance\AbstractResource;
use Evance\ApiClient;
use Webmozart\Assert\Assert;

class ProductTranslations extends AbstractResource
{
    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    public function get($productId)
    {
        Assert::integerish($productId, __METHOD__ . ' expects a $productId as an integer');
        return $this->call('GET', "/products/{$productId}/translations.json");
    }

    public function getLocales($productId)
    {
        Assert::integerish($productId, __METHOD__ . ' expects a $productId as an integer');
        return $this->call('GET', "/products/{$productId}/locales.json");
    }


    public function add($productId, $translations)
    {
        Assert::integerish($productId, __METHOD__ . ' expects an $producId as an integer');
        Assert::isArray($translations, __METHOD__ . ' expects $translations to be supplied as an array');
        Assert::keyExists($translations, "translations",  __METHOD__ . ' expects $translations to contain key of "translations"' .
            ' with value of object or array');
        return $this->call('POST', "/products/{$productId}/translations.json", $translations);
    }

    public function getById($productId, $translationsId)
    {
        Assert::integerish($productId, __METHOD__ . ' expects an $productId as an integer');
        Assert::integerish($translationsId, __METHOD__ . ' expects an $translationsId as an integer');
        return $this->call('GET', "/products/{$productId}/translations/{$translationsId}.json");
    }

    public function update($productId, $translationsId, $translations)
    {
        Assert::integerish($productId, __METHOD__ . ' expects an $productId as an integer');
        Assert::integerish($translationsId, __METHOD__ . ' expects an $translationsId as an integer');
        Assert::isArray($translations, __METHOD__ . ' expects $translations to be supplied as an array');
        Assert::keyExists($translations, "translations",  __METHOD__ . ' expects $translations to contain key of "translations"' .
            ' with value of object or array');
        return $this->call('PUT', "/products/{$productId}/translations/{$translationsId}.json", $translations);
    }

    public function delete($productId, $translationsId)
    {
        Assert::integerish($productId, __METHOD__ . ' expects an $productId as an integer');
        Assert::integerish($translationsId, __METHOD__ . ' expects an $translationsId as an integer');
        return $this->call('DELETE', "/products/{$productId}/translations/{$translationsId}.json");
    }
}
