<?php

namespace Evance\Service;

use Evance\AbstractService;
use Evance\App;
use Evance\Literal\Object;
use Evance\Resource\Contacts as ContactsResource;

class Contact extends AbstractService
{
    /**
     * Contact constructor.
     * @param App $client
     * @param array $properties
     *
     * todo object defaults to be added
     */
    public function __construct(App $client, $properties = [])
    {
        $properties = (new Object([
            'id' => null
        ]))->merge($properties);
        parent::__construct($client, new ContactsResource($client), 'contact',  $properties);
    }

}