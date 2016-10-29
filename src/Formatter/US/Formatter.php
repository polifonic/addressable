<?php

namespace Polifonic\Addressable\Model\Formatter\US;

use Polifonic\Addressable\Formatter\AbstractFormatter;
use Polifonic\Addressable\Model\AddressableInterface;

class Formatter extends AbstractFormatter
{
    public function getCityLine(AddressableInterface $address, $flags = 0)
    {
        return sprintf(
            '%s  %s %s',
            $address->getLocality(),
            $address->getRegion(),
            $address->getPostalCode()
        );
    }
}
