<?php

namespace Evance\Service\Shipping\Resource;

use Evance\Resource;

class Services extends Resource
{


    public function add($properties)
    {
        return $this->call('POST', '/shipping/services.json', ['shippingService' => $properties]);
    }


    public function delete($id)
    {

    }


    public function get($id)
    {

    }


    public function update($id, $properties)
    {

    }

}