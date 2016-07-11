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
        $this->assertInstanceOf('Alom\Graphviz\RawText', $label);
        $label = $label->getText();

        $this->assertContains('<__class__> Entity\\\\User', $label);
        $this->assertContains('username : string', $label);

        $folderNode = $graph->get('cluster_Entity')->get('Entity\Folder');
        $label = $folderNode->getAttributes()->get('label');
        $this->assertInstanceOf('Alom\Graphviz\RawText', $label);
        $label = $label->getText();

        $this->assertContains('<__class__> Entity\\\\Folder', $label);
        $this->assertContains('<files> files : Entity\\\\File[]', $label);
        $this->assertContains('<user> user : Entity\\\\User', $label);

        $this->assertTrue($graph->hasEdge(array(array('Entity\User', 'folders'), array('Entity\Folder', '__class__'))));
        $this->assertTrue($graph->hasEdge(array(array('Entity\Folder', 'user'), array('Entity\User', '__class__'))));
    }
}
