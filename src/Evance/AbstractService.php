<?php

namespace Evance;

use Evance\Literal\Object;
use Webmozart\Assert\Assert;

class AbstractService extends Object
{

    /** @var App */
    private $client;

    /** @var string */
    private $serviceName;

    /** @var Resource */
    private $resource;

    /** @var string */
    private $systemIdProperty = 'id';

    /**
     * AbstractService constructor.
     * @param App $client
     * @param AbstractResource $resource
     * @param string $serviceName
     * @param array $properties
     */
    public function __construct(App $client, AbstractResource $resource, $serviceName, $properties = [])
    {
        $this->client = $client;
        $this->resource = $resource;
        $this->serviceName = $serviceName;
        parent::__construct($properties);
    }

    /**
     * Attempts to add object data to the resource's API endpoint.
     * All properties for the Object are sent via the resource to the API.
     * Note: If a system ID is set for the object it will be ignored and a new ID
     * will be generated.
     * Returns TRUE if the addition was successful, or FALSE if not.
     * @see save
     * @return bool
     */
    public function add()
    {
        try {
            $response = $this->resource->add([$this->getServiceName() => $this->getProperties()]);
        } catch (\Exception $e) {
            // todo error handling
            return false;
        }
        $this->setProperties($response[$this->getServiceName()]);
        return true;
    }

    /**
     * Overwrites the object's delete method with a delete method that attempts to delete the entire object.
     * Technically we should not be deleting properties from the service object so this should be ok.
     * @return bool
     */
    public function delete()
    {
        try {
            $this->resource->delete($this->getId());
        } catch (\Exception $e) {
            // failure to delete should always result in an exception
            // todo error handling
            return false;
        }
        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function fetchById($id)
    {
        try {
            $response = $this->resource->get($id);
            if (!array_key_exists($this->getServiceName(), $response)) {
                throw new \RuntimeException(__METHOD__ . ' could not interpret the serviceName from the response');
            }
        } catch (\Exception $e) {
            //$body = ($e->getResponse()->getBody(true));
            // $json = json_decode($body, true);
            // todo: deliver error message better
            return false;
        }
        $this->setProperties($response[$this->getServiceName()]);
        return true;
    }

    /**
     * Returns the PHP App Client for the Service.
     * @return App
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * The default method for obtaining the system ID property associated with
     * a GET, PUT or DELETE API request where the system ID is required.
     * @return mixed
     */
    public function getId()
    {
        return $this->get($this->systemIdProperty);
    }

    /**
     * Gets the default resource handler for making API requests.
     * @return Resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Returns the resource name that encapsulates the data for this object type.
     * @return string
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * Determines whether the System ID for the object has been set.
     * Generally, this is used internally to determine whether a save
     * operation is a POST (with no ID) or a PUT (with an ID).
     * @return bool
     */
    public function hasId()
    {
        return !empty($this->getId());
    }

    /**
     * Attempts to save the Object Data to the API Resource.
     * The save method automatically determines whether it should add() or update() the object
     * depending on whether the object has a system ID set or not.
     * However, you may also use add() or update() independently.
     * Returns TRUE if the save was successful, or FALSE if not.
     * @return bool
     */
    public function save()
    {
        return (!$this->hasId()) ? $this->add() : $this->update();
    }

    /**
     * Sets the System ID property for the object.
     * By default this should usually be 'id' and you should not need to change it
     * unless the id property is different.
     * @param string $propertyName
     * @return $this
     */
    protected function setSystemIdProperty($propertyName)
    {
        Assert::stringNotEmpty($propertyName, __METHOD__ . ' expects a non-empty string for $propertyName');
        $this->systemIdProperty = $propertyName;
        return $this;
    }

    /**
     * Attempts to update an Object based on its system ID.
     * All properties for the object are sent via the resource to the API.
     * It is up to the API to determine which properties it wishes to map.
     * Returns TRUE if the update was successful, or FALSE if not.
     * @see save
     * @return bool
     */
    public function update()
    {
        try {
            $response = $this->resource->update($this->getId(), [$this->getServiceName() => $this->getProperties()]);
        } catch (\Exception $e) {
            // todo error handling
            return false;
        }
        $this->setProperties($response[$this->getServiceName()]);
        return true;
    }

}