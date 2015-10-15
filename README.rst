DoctrineExtraBundle
===================

Graph tool for Doctrine. Relies on `Graphviz <http://www.graphviz.org/>`_.

.. image:: Resources/demo.png

Installation
-----------
Install the latest version with

.. code-block:: bash

    $ composer require alexandresalome/doctrine-extra-bundle

Register the bundle in your kernel

.. code-block:: php

    <?php

    // app/AppKernel.php
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Alex\DoctrineExtraBundle\AlexDoctrineExtraBundle(),
        );
        // ...
    }

Usage
-----

**Dump entity manager schema as graph**

.. code-block:: bash

    $ php app/console doctrine:mapping:graphviz
    digraph G { ... }  # outputs a dot graph

If you want to create a PDF file out of it, with Linux:

.. code-block:: bash

    $ php app/console doctrine:mapping:graphviz | dot -Tpdf -oout.pdf
    $ xdg-open out.pdf
