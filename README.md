UAMAddressBundle
================

The UAMAddressBundle adds various address-related packages to your symfony2 app.

Requirements
------------


Installation
------------

Add the bundle to your app's `composer.json` file:

```yaml
	require: {
		"uam/address-bundle": "~0.2"
	}
```

Enable the bundle in your app's kernel:

```php
# app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            …
            new UAM\Bundle\AddressBundle\UAMAddressBundle()
        );

    }
```

Then update your dependencies using composer:

```
php composer.phar install
```

or

```
php composer.phar update
```

Propel Addressable behavior
---------------------------

The UAMADdressBundle includes the [Propel Addressable behavior](http://gitlab.united-asian.com/address/propel-addressable-behavior).

To enable it, include the supplied propel configuration file in your app's `config.yml`.

```yaml
# app/config/config.yml

imports:
    - { resource: "@UAMAddressBundle/Resources/config/propel.yml" }
```

Twig Address extension
----------------------

The UANAddressBundle includes the [Twig Address extension](http://gitlab.united-asian.com/address/twig-address-extension).

Address formatter
-----------------

The UANAddressBundle includes the [Address formatter](http://gitlab.united-asian.com/address/formatter).