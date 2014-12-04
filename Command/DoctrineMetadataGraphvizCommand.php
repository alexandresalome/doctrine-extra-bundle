<?php

namespace Alex\DoctrineExtraBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Alex\DoctrineExtraBundle\Graphviz\DoctrineMetadataGraph;

/**
 * Tool to generate graph from mapping informations.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class DoctrineMetadataGraphvizCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('doctrine:mapping:graphviz')
            ->addOption('no-fields', null, InputOption::VALUE_NONE, 'If defined, fields aren\'t included in the graph.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $graph = new DoctrineMetadataGraph($em, array(
            'no-fields' => $input->getOption('no-fields')
        ));

        $output->writeln($graph->render());
    }
}
