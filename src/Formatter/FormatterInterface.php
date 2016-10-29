<?php

namespace Polifonic\Addressable\Formatter;

use Polifonic\Addressable\Model\AddressableInterface;

interface FormatterInterface
{
    const SHOW_COUNTRY = 1;

    const SHOW_COUNTRY_IF_NOT_BASE = 2;

    const SHOW_POSTAL_CODE = 4;

    const FULL = 5;

    const MEDIUM = 7;

    public function getLines(AddressableInterface $address, $flags = 0);

    public function getCityLine(AddressableInterface $address, $flags = 0);

    public function formatHtml(AddressableInterface $address, $flags = 0);

    public function formatText(AddressableInterface $address, $flags = 0);

    public function formatCountry(AddressableInterface $address);
}
