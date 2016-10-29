<?php

namespace Polifonic\Addressable\Symfony\Maxmind;

use Maxmind\Bundle\GeoipBundle\Service\GeoipManager as BaseManager;
use Symfony\Component\Debug\Exception\ContextErrorException;

class GeoipManager extends BaseManager
{
    public function getRegion($ip = null)
    {
        $region = null;

        try {
            $region = parent::getRegion($ip);
        } catch (ContextErrorException $e) {
            //log
        }

        return $region;
    }
}
