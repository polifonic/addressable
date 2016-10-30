<?php

namespace Polifonic\Addressable\Symfony\Form\Type;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressableFormType extends AbstractType
{
    protected $geoip_listener;

    protected $geoip_enabled;

    public function __construct(EventSubscriberInterface $geoip_listener, $geoip_enabled = true)
    {
        $this->geoip_listener = $geoip_listener;

        $this->geoip_enabled = $geoip_enabled;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'polifonic-addressable',
            'data_class' => 'Polifonic\Addressable\Model\AddressableInterface',
            'geoip' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('street', TextType::class, array(
            'label' => 'address.form.street.label',
            'required' => false,
        ));

        $builder->add('complement', TextType::class, array(
            'label' => 'address.form.complement.label',
            'required' => false,
        ));

        $builder->add('locality', TextType::class, array(
            'label' => 'address.form.locality.label',
            'required' => false,
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
            'required' => false,
            'empty_value' => '',
            'empty_data' => null,
        ));

        if ($this->isGeoipEnabled() && true === $options['geoip']) {
            $builder->addEventSubscriber($this->getGeoipListener());
        }
    }

    public function getBlockPrefix()
    {
        return 'uam_address';
    }

    protected function getGeoipListener()
    {
        return $this->geoip_listener;
    }

    protected function isGeoipEnabled()
    {
        return true === $this->geoip_enabled;
    }
}
