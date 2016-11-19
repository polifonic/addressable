<?php

namespace Polifonic\Addressable\Symfony\EventListener;

use Exception;
use GeoIp2\ProviderInterface;
use GeoIp2\Exception\AddressNotFoundException;
use MaxMind\Db\Reader\InvalidDatabaseException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;

class GeoipListener implements EventSubscriberInterface
{
    protected $request_stack;

    protected $geoip_provider;

    protected $local_ip;

    public static function getSubscribedEvents()
    {
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function __construct(RequestStack $request_stack, ProviderInterface $geoip_provider)
    {
        $this->request_stack = $request_stack;

        $this->geoip_provider = $geoip_provider;
    }

    public function setLocalIp($ip = null)
    {
        $this->local_ip = $ip;
    }

    public function preSetData(FormEvent $event)
    {
        $addressable = $event->getData();

        $geoip = $this->getGeoipRecord();

        if (!$addressable || !$geoip) {
            return;
        }

        if (!$addressable->getCountryId()) {
            $addressable->setCountryId($geoip->country->isoCode);
        }

        if (!$addressable->getLocality()) {
            $addressable->setLocality($geoip->city->name);
        }

        if (!$addressable->getPostalCode()) {
            $addressable->setPostalCode($geoip->postal->code);
        }

        if (!$addressable->getRegion()) {
            $addressable->setRegion($geoip->mostSpecificSubdivision->name);
        }
    }

    protected function getGeoipRecord()
    {
        $ip = $this->getClientIp();

        try {
            return $this->getGeoipProvider()
                ->city($ip);
        } catch (AddressNotFoundException $e) {
            // TODO [OP 2016-11-19] Log error somewhere
        } catch (InvalidDatabaseException $e) {
            // TODO [OP 2016-11-19] Log error somewhere
        } catch (Exception $e) {
            // TODO [OP 2016-11-19] Log error somewhere
        }
    }

    protected function getClientIp()
    {
        if ($this->local_ip) {
            return $this->local_ip;
        }

        $request = $this->getRequestStack()
            ->getCurrentRequest();

        return $request->getClientIp();
    }

    protected function getGeoIpProvider()
    {
        return $this->geoip_provider;
    }

    protected function getRequestStack()
    {
        return $this->request_stack;
    }
}
