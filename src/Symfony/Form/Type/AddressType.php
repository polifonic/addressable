<?php

namespace Polifonic\Addressable\Symfony\Form\Type;

use Exception;
use Maxmind\Bundle\GeoipBundle\Service\GeoipManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    protected $request_stack;

    protected $geoip_manager;

    protected $local_ip;

    public function __construct(RequestStack $request_stack, GeoipManager $geoip_manager)
    {
        $this->request_stack = $request_stack;

        $this->geoip_manager = $geoip_manager;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'polifonic-addressable',
            'data_class' => 'Polifonic\Addressable\Model\AddressableInterface',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('street', TextType::class, array(
            'label' => 'address.form.street.label',
            'required' => true,
        ));

        $builder->add('complement', TextType::class, array(
            'label' => 'address.form.complement.label',
            'required' => false,
        ));

        $builder->add('locality', TextType::class, array(
            'label' => 'address.form.locality.label',
            'required' => true,
        ));

        $builder->add('region', TextType::class, array(
            'label' => 'address.form.region.label',
            'required' => false,
        ));

        $builder->add('postal_code', TextType::class, array(
            'label' => 'address.form.postal_code.label',
            'required' => false,
        ));

        $builder->add('country_id', CountryType::class, array(
            'label' => 'address.form.country_id.label',
            'required' => true,
            'empty_value' => '',
            'empty_data' => null,
        ));

        $this->applyGeoip($builder);
    }

    public function setLocalIp($ip = null)
    {
        $this->local_ip = $ip;
    }

    public function getBlockPrefix()
    {
        return 'uam_address';
    }

    protected function applyGeoip(FormBuilderInterface $builder)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $ip = $this->getClientIp();

            try {
                $geoip = $this->getGeoIpManager()->lookup($ip);
            } catch (Exception $e) {
                // [UKS 2016-May-19 ignore error and don't go further
                // may be log the error later
                return;
            }

            $address = $event->getData();

            if (!$address || !$geoip) {
                return;
            }

            if (!$address->getCountryId() && $country_id = $geoip->getCountryCode()) {
                $address->setCountryId($country_id);
            }

            if (!$address->getLocality() && $city = $geoip->getCity()) {
                $address->setLocality($city);
            }

            if (!$address->getPostalCode() && $postal_code = $geoip->getPostalCode()) {
                $address->setPostalCode($postal_code);
            }

            if (!$address->getRegion() && $region = $geoip->getRegion()) {
                $address->setRegion($region);
            }
        });
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

    protected function getGeoIpManager()
    {
        return $this->geoip_manager;
    }

    protected function getRequestStack()
    {
        return $this->request_stack;
    }
}
