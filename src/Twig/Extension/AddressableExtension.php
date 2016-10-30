<?php

namespace Polifonic\Addressable\Twig\Extension;

use Twig_Extension;
use Twig_SimpleFilter;
use Polifonic\Addressable\Formatter\Formatter;

class AddressableExtension extends Twig_Extension
{
    protected $formatter;

    public function __construct(Formatter $formatter)
    {
        $this->formatter = $formatter;
    }

    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('address', array($this, 'format')),
        );
    }

    public function format($address)
    {
        return $this->formatter->formatHtml($address);
    }

    public function getName()
    {
        return 'address';
    }
}
