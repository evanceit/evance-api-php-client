<?php

namespace Evance\Service;

use Evance\AbstractService;
use Evance\ApiClient;
use Evance\Literal\EvObject;
use Evance\Resource\Contacts as ContactsResource;

/**
 * @method string getFirstname()
 * @method string getSurname()
 * @method string getThumbnail()
 * @method string getType()
 *
 * @method setFirstname(string $firstname)
 * @method setLastname(string $lastname)
 * @method setThumbnail(string|null $thumbnail)
 * @method setType(string $type) // Contact Type e.g. user, branch, hq...
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
        $properties = (new EvObject([
            'id'            => null,
            'firstname'     => '',
            'lastname'       => '',
            'type'          => 'user',
            'username'      => '',
            'thumbnail'     => null
        ]))->merge($properties);
        parent::__construct($client, new ContactsResource($client), 'contact',  $properties);
    }

    public function fetchByReference($reference)
    {
        $result = $this->getResource()->searchWithReference($reference);
       if(!is_array($result) || !isset($result['contacts']) || empty($result['contacts'])){
           return false;
       }
       $contact = $result['contacts'][0];
       
       $this->setProperties($contact);
       
       return true;
       
    }
}