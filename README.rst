DoctrineExtraBundle
===================

Graph tool for Doctrine. Relies on `Graphviz <http://www.graphviz.org/>`_.

.. image:: Resources/demo.png

Installation
-----------
Install the latest version with

.. code-block:: bash

    $ composer require --dev alexandresalome/doctrine-extra-bundle

Then, enable the bundle by adding the following line in the ``app/AppKernel.php``
file of your project:

.. code-block:: php

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
