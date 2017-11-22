REST Bundle
===================

Description

----------


Install
-------------

#### Composer
Install package via composer:

```bash
$ composer require opstalent/rest
```

Enable `OpstalentRestBundle` in `/app/AppKernel.php`

```php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Opstalent\RestBundle\OpstalentRestBundle(),
        // ...
    );
}
```


----------

Annotations
-------------



----------

API Reference
-------------


License
-------------

[This bundle is under the MIT license.](LICENSE)
