DoctrineExtraBundle
===================

Graph tool for Doctrine. Relies on `Graphviz <http://www.graphviz.org/>`_.

.. images:: Resources/demo.png

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
