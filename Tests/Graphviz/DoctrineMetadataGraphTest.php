<?php

namespace Alex\DoctrineExtraBundle\Tests\Graphviz;

use Alex\DoctrineExtraBundle\Graphviz\DoctrineMetadataGraph;
use Alex\DoctrineExtraBundle\Tests\AbstractTest;
use Alex\DoctrineExtraBundle\Tests\Sample;
use Alom\Graphviz\Node;
use Alom\Graphviz\Subgraph;

class DoctrineMetadataGraphTest extends \PHPUnit_Framework_TestCase
{
    public function testSimple()
    {
        $em = Sample::getEntityManager('simple');

        $graph = new DoctrineMetadataGraph($em);

        $userNode = $graph->get('cluster_Entity')->get('Entity\User');

        $label = $userNode->getAttributes()->get('label');

        $this->assertContains('<__class__> Entity\User', $label);
        $this->assertContains('<username> username : string', $label);
    }
}
