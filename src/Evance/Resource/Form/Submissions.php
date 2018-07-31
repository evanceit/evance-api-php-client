<?php

namespace Evance\Resource\Form;

use Evance\AbstractResource;
use Evance\ApiClient;
use Webmozart\Assert\Assert;

class Submissions extends AbstractResource
{

    public function __construct(ApiClient $client)
    {
        parent::__construct($client);
    }

    public function get($id)
    {
        Assert::integerish($id, __METHOD__ . ' expects an $id as an integer');
        return $this->call('GET', "/forms/{$id}/submissions.json");
    }

}