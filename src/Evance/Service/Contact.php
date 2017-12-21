<?php

namespace Evance\Service;

use Evance\AbstractService;
use Evance\ApiClient;
use Evance\Literal\Object;
use Evance\Resource\Contacts as ContactsResource;

/**
 * @method string getFirstname()
 * @method string getSurname()
 * @method string getType()
 *
 * @method setFirstname(string $firstname)
 * @method setLastname(string $lastname)
 * @method setType(string $type) // Contatc Type e.g. user, branch, hq...
 *
 * @package Evance\Service\Contact
 */
class Contact extends AbstractService
{
    /**
     * Contact constructor.
     * @param ApiClient $client
     * @param array $properties
     */
    public function __construct(ApiClient $client, $properties = [])
    {
        $properties = (new Object([
            'id' => null,
            'firstname' => '',
            'surname' => '',
            'type' => 'user'
        ]))->merge($properties);
        parent::__construct($client, new ContactsResource($client), 'contact',  $properties);
    }

}