<?php

namespace Polifonic\Addressable\Formatter;

use Polifonic\Addressable\Model\AddressableInterface;

class Formatter
{
    private static $instance = null;

    protected $base_country;

    protected $registry = array();

    /**
     * Singleton pattern.
     *
     * @return Formatter
     */
    public static function getInstance()
    {
        if (!is_object(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getBaseCountry()
    {
        return $this->base_country;
    }

    public function setBaseCountry($country)
    {
        $this->base_country = $country;
    }

    public function formatHtml(AddressableInterface $address, $flags = 0)
    {
        $formatter = $this->getFormatter($address->getCountryId());

        return $formatter->formatHtml($address, $flags);
    }

    public function formatText(AddressableInterface $address, $flags = 0)
    {
        $formatter = $this->getFormatter($address->getCountryId());

        return $formatter->formatText($address, $flags);
    }

    public function getFormatter($country_id)
    {
        if (array_key_exists($country_id, $this->registry)) {
            return $this->registry[$country_id];
        } else {
            return $this->getDefaultFormatter($country_id);
        }
    }

    public function register($country_id, FormatterInterface $formatter)
    {
        if (array_key_exists($country_id, $this->registry)) {
            throw new Exception('Formatter already registered for'.$country_id.'!');
        }

        $this->registry[$country_id] = $formatter;
    }

    protected function getDefaultFormatter($country_id)
    {
        $formatter = null;

        $class = 'UAM\\Address\\Formatter\\'.$country_id.'\\Formatter';

        if (class_exists($class)) {
            $formatter = new $class();

            $this->register($country_id, $formatter);
        }

        // Fall back to formatter for base country
        if (!$formatter) {
            $formatter = $this->getFormatter($this->getBaseCountry());
        }

        // Fall back to US formatter
        if (!$formatter) {
            $formatter = $this->getFormatter('US');
        }

        return $formatter;
    }

    /**
     * Prevents instantiation.
     */
    private function __construct()
    {
    }

    /**
     * Prevents Cloning of this object.
     */
    private function __clone()
    {
    }
}
