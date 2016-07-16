# DoctrineExtraBundle

![Build status](https://travis-ci.org/alexandresalome/doctrine-extra-bundle.png?branch=master) [![Latest Stable Version](https://poser.pugx.org/alexandresalome/doctrine-extra-bundle/v/stable)](https://packagist.org/packages/alexandresalome/doctrine-extra-bundle) [![Total Downloads](https://poser.pugx.org/alexandresalome/doctrine-extra-bundle/downloads)](https://packagist.org/packages/alexandresalome/doctrine-extra-bundle) [![License](https://poser.pugx.org/alexandresalome/doctrine-extra-bundle/license)](https://packagist.org/packages/alexandresalome/doctrine-extra-bundle) [![Monthly Downloads](https://poser.pugx.org/alexandresalome/doctrine-extra-bundle/d/monthly)](https://packagist.org/packages/alexandresalome/doctrine-extra-bundle) [![Daily Downloads](https://poser.pugx.org/alexandresalome/doctrine-extra-bundle/d/daily)](https://packagist.org/packages/alexandresalome/doctrine-extra-bundle)

Graph tool for Doctrine. Relies on [Graphviz](http://www.graphviz.org/).

* [View CHANGELOG](CHANGELOG.md)
* [View CONTRIBUTORS](CONTRIBUTORS.md)

![Demo](Resources/demo.png)

## Installation

Install the latest version with

```bash
composer require --dev alexandresalome/doctrine-extra-bundle
```

Then, enable the bundle by adding the following line in the ``app/AppKernel.php``
file of your project:

```php
// app/AppKernel.php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        //...
        if (in_array($this->getEnvironment(), ['dev', 'test'])) {
            // ...
            // Because the vendor code could be not present, you should check if the bundle is here before using it.
            $bundles[] = new Alex\DoctrineExtraBundle\AlexDoctrineExtraBundle();
        }


        // ...
    }

    // ...
}
```

## Usage

### Dump entity manager schema as graph

```bash
php app/console doctrine:mapping:graphviz
```

If you want to create a PDF file out of it, with Linux:

.. code-block:: bash

```
php app/console doctrine:mapping:graphviz | dot -Tpdf -oout.pdf
xdg-open out.pdf
```

## Development

### Generate sample graphs

A set of sample entities are available to test internally the schema generations. You can generate the graph for any of the samples (located in Tests/Fixtures) by running:

```bash
./Resources/bin/graph Simple | dot -Tpdf -oout.pdf
xdg-open out.pdf
```
