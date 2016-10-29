PolifonicAddressable
====================


Requirements
------------


PolifonicAddressableBundle - a Symfony bundle
---------------------------------------------

The package includes a `PolifonicAddressableBundle` which can be added to your symfony 2 app.

The bundles automatically sets up the required services.


### Installation

Add the bundle to your app's `composer.json` file:

```yaml
	require: {
		"polifonic/addressable-bundle": "^0.4"
	}
```

Enable the bundle in your app's kernel:

```php
# app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            …
            new Polifonic\Addressable\Symfony\PolifonicAddressable()
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

Twig Addressable extension
----------------------

The PolifonicAddressable library includes a twig addressable extension.

Address formatter
-----------------

The PolifonicAddressable library includes the polifonic address formater.

Propel Addressable behavior
---------------------------

The PolifonicAddressable library includes the Propel Addressable behavior.

The behavior is enabled by default if you use the Symfony PolifonicAddressableBundle.
