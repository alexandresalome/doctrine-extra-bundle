<?php

namespace Alex\DoctrineExtraBundle\Command;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Alex\DoctrineExtraBundle\Graphviz\DoctrineMetadataGraph;

/**
 * Tool to generate graph from mapping informations.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class DoctrineMetadataGraphvizCommand extends Command
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct();

        $this->doctrine = $doctrine;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('doctrine:mapping:graphviz')
            ->addOption(
              'no-reverse',
              null,
              InputOption::VALUE_NONE,
              'Do not output "reverse" associations'
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->doctrine->getManager();
        $graph = new DoctrineMetadataGraph($em, array(
          'includeReverseEdges' => !$input->hasOption('no-reverse'),
        ));

        $output->writeln($graph->render());

        return 0;
    }
}
