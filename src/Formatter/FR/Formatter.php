<?php

namespace Polifonic\Addressable\Formatter\FR;

use Polifonic\Addressable\Formatter\AbstractFormatter;
use Polifonic\Addressable\Model\Behavior\AddressableInterface;

class Formatter extends AbstractFormatter
{
    public function getLines(AddressableInterface $address, $flags = 0)
    {
        $result = array(
            $address->getStreet(),
            $address->getComplement(),
            $this->getCityLine($address),
            $address->getRegion(),
            $this->formatCountry($address),
        );

        return array_filter($result);
    }

    public function getCityLine(AddressableInterface $address, $flags = 0)
    {
        return sprintf(
            '%s %s',
            $address->getPostalCode(),
            $address->getLocality()
        );
    }
}
