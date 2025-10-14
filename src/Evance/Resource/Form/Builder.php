<?php

namespace Evance\Resource\Form;

use Evance\AbstractResource;
use Evance\ApiClient;
use Webmozart\Assert\Assert;

/**
 * @deprecated
 */
class Builder extends AbstractResource
{

    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    /**
     * @param $id
     * @return mixed
     * @deprecated
     */
    public function get($id = null)
    {
        if($id) {
            Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
            return $this->call('GET', "/forms/{$id}.json");
        } else {
            return $this->call('GET', "/forms.json");
        }
    }

}