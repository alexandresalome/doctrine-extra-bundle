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
    public function __construct(ObjectManager $manager, array $options = array())
    {
        parent::__construct('G');

        $this->attr('node', array(
            'shape' => 'record'
        ));
        $this->set('rankdir', 'LR');

        $options = array_merge(
            array('includeReverseEdges' => true),
            $options
        );

        $data = $this->createData($manager, $options);

        $clusters = array();

        foreach ($data['entities'] as $class => $entity) {
            list($cluster, $label) = $this->splitClass($class);
            if (!isset($clusters[$cluster])) {
                $escaped = str_replace("\\", "_", $cluster);
                $clusters[$cluster] = $this->subgraph('cluster_'.$escaped)
                    ->set('label', $cluster)
                    ->set('style', 'filled')
                    ->set('color', '#eeeeee')
                    ->attr('node', array(
                        'style' => 'filled',
                        'color' => '#eecc88',
                        'fillcolor' => '#FCF0AD',
                    ))
                ;
            }

            $label = $this->getEntityLabel($label, $entity);
            $clusters[$cluster]->node($class, array(
                'label' => '"'.$label.'"',
                '_escaped' => false
            ));
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

    private function createData(ObjectManager $manager, array $options)
    {
        $data = array('entities' => array(), 'relations' => array());
        $passes = array(
            new ImportMetadataPass($options['includeReverseEdges']),
            new InheritancePass(),
        );

        foreach ($passes as $pass) {
            $data = $pass->process($manager->getMetadataFactory(), $data);
        }

        return $data;
    }

    private function getEntityLabel($class, $entity)
    {
        // Beware that this value will not be escaped, so every special character must be escaped

        $result = '{{<__class__> '.$class.'|';

        foreach ($entity['associations'] as $name => $val) {
            list($ignored, $val) = $this->splitClass($val);
            $escVal = str_replace("\\", "\\\\", $val);
            $result .= '<'.$name.'> '.$name.' : '.$escVal." \\l|";
        }

        foreach ($entity['fields'] as $name => $val) {
            $escVal = str_replace("\\", "\\\\", $val);
            $result .= $name.' : '.$escVal." \\l";
        }

        $result .= '}}';

        return $result;
    }

    private function splitClass($entityName)
    {
        $pos = strrpos($entityName, "\\");
        if ($pos === false) {
            return array('', $entityName);
        }

        return array(
            substr($entityName, 0, $pos),
            substr($entityName, $pos + 1)
        );
    }
}
