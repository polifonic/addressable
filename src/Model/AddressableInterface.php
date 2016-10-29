<?php

namespace Polifonic\Addressable\Model;

interface AddressableInterface
{
    public function getStreet();

    public function getComplement();

    public function getLocality();

    public function getRegion();

    public function getPostalCode();

    public function getCountryId();
}
