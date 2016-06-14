<?php

namespace Alex\DoctrineExtraBundle\Graphviz;

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;

use Alex\DoctrineExtraBundle\Graphviz\Pass\ImportMetadataPass;
use Alex\DoctrineExtraBundle\Graphviz\Pass\InheritancePass;
use Alex\DoctrineExtraBundle\Graphviz\Pass\ShortNamePass;

use Alom\Graphviz\Digraph;

class DoctrineMetadataGraph extends Digraph
{
    public function __construct(ObjectManager $manager)
    {
        parent::__construct('G');

        $this->attr('node', array(
            'shape' => 'record'
        ));
        $this->set('rankdir', 'LR');

        $data = $this->createData($manager);

        $clusters = array();

        foreach ($data['entities'] as $class => $entity) {
            $clusterName = $this->getCluster($class);
            if (!isset($clusters[$clusterName])) {
                $clusters[$clusterName] = $this->subgraph('cluster_'.$clusterName)
                    ->set('label', $clusterName)
                    ->set('style', 'filled')
                    ->set('color', '#eeeeee')
                    ->attr('node', array(
                        'style' => 'filled',
                        'color' => '#eecc88',
                        'fillcolor' => '#FCF0AD',
                    ))
                ;
            }

            $label = $this->getEntityLabel($class, $entity);
            $clusters[$clusterName]->node($class, array('label' => $label));
        }

        foreach ($data['relations'] as $association) {
            $attr = array();
            switch ($association['type']) {
                case 'one_to_one':
                case 'one_to_many':
                case 'many_to_one':
                case 'many_to_many':
                    $attr['color'] = '#88888888';
                    $attr['arrowhead'] = 'none';
                    break;
                case 'extends':
            }

            $this->edge(array($association['from'], $association['to']), $attr);
        }
    }

    private function createData(ObjectManager $manager)
    {
        $data = array('entities' => array(), 'relations' => array());
        $passes = array(
            new ImportMetadataPass(),
            new InheritancePass(),
            new ShortNamePass()
        );

        foreach ($passes as $pass) {
            $data = $pass->process($manager->getMetadataFactory(), $data);
        }

        return $data;
    }

    private function getEntityLabel($class, $entity)
    {
        $class = str_replace('\\', '\\\\', $class); // needed because of type "record"
        $result = '{{<__class__> '.$class;

        foreach ($entity['fields'] as $name => $val) {
            $result .= '| <'.$name.'> '.$name.' : '.$val.PHP_EOL;
        }

        foreach ($entity['associations'] as $name => $val) {
            $result .= '| <'.$name.'> '.$name.' : '.$val.PHP_EOL;
        }

        $result .= '}}';

        return $result;
    }

    private function getCluster($entityName)
    {
        $exp = preg_split('/\\\\|:/', $entityName);
        $name = array_pop($exp);

        return implode('_', $exp);
    }
}
