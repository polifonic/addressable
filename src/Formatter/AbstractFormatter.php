<?php

namespace Polifonic\Addressable\Formatter;

use Symfony\Component\Locale\Locale;
use Polifonic\Addressable\Model\AddressableInterface;

abstract class AbstractFormatter implements FormatterInterface
{
    abstract public function getCityLine(AddressableInterface $address, $flags = 0);

    public function getLines(AddressableInterface $address, $flags = 0)
    {
        $result = array(
            $address->getStreet(),
            $address->getComplement(),
            $this->getCityLine($address),
            $this->formatCountry($address),
        );

        return array_filter($result);
    }

    public function formatHtml(AddressableInterface $address, $flags = 0)
    {
        return implode('<br />', $this->getLines($address, $flags));
    }

    public function formatText(AddressableInterface $address, $flags = 0)
    {
        return implode("\n", $this->getLines($address, $flags));
    }

    public function formatCountry(AddressableInterface $address)
    {
        $locale = $this->getLocale();
        $locale = Locale::getPrimaryLanguage($locale);
        $countries = Locale::getDisplayCountries($locale);

        $country_id = $address->getCountryId();
        if (isset($countries[$country_id])) {
            return $countries[$country_id];
        }

        return $country;
    }

    protected function getLocale()
    {
        return Locale::getDefault();
    }
}
