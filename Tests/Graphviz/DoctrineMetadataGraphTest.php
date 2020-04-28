<?php

namespace Alex\DoctrineExtraBundle\Tests\Graphviz;

use Alex\DoctrineExtraBundle\Graphviz\DoctrineMetadataGraph;
use Alex\DoctrineExtraBundle\Tests\AbstractTest;
use Alex\DoctrineExtraBundle\Tests\Sample;
use Alom\Graphviz\Node;
use Alom\Graphviz\Subgraph;
use PHPUnit\Framework\TestCase;

class DoctrineMetadataGraphTest extends TestCase
{
    public function testSimple()
    {
        $em = Sample::getEntityManager('Simple');

        $graph = new DoctrineMetadataGraph($em);

        $simpleId = 'cluster_Alex_DoctrineExtraBundle_Tests_Fixtures_Simple';
        $userId = 'Alex\\DoctrineExtraBundle\\Tests\\Fixtures\\Simple\\User';
        $folderId = 'Alex\\DoctrineExtraBundle\\Tests\\Fixtures\\Simple\\Folder';

        $userNode = $graph->get($simpleId)->get($userId);
        $label = $userNode->getAttributes()->get('label');
        $this->assertInstanceOf('Alom\Graphviz\RawText', $label);
        $label = $label->getText();

        $this->assertContains('<__class__> User', $label);
        $this->assertContains('username : string', $label);

        $folderNode = $graph->get($simpleId)->get($folderId);
        $label = $folderNode->getAttributes()->get('label');
        $this->assertInstanceOf('Alom\Graphviz\RawText', $label);
        $label = $label->getText();

        $this->assertContains('<__class__> Folder', $label);
        $this->assertContains('<files> files : File[]', $label);
        $this->assertContains('<user> user : User', $label);

        $this->assertTrue($graph->hasEdge(array(array($userId, 'folders'), array($folderId, '__class__'))));
        $this->assertTrue($graph->hasEdge(array(array($folderId, 'user'), array($userId, '__class__'))));
    }

    public function testInheritance()
    {
        $em = Sample::getEntityManager('Inheritance');
        $graph = new DoctrineMetadataGraph($em);

        $inheritanceId = 'cluster_Alex_DoctrineExtraBundle_Tests_Fixtures_Inheritance';

        $animalId = 'Alex\\DoctrineExtraBundle\\Tests\\Fixtures\\Inheritance\\Animal';
        $frogId = 'Alex\\DoctrineExtraBundle\\Tests\\Fixtures\\Inheritance\\Frog';
        $horseId = 'Alex\\DoctrineExtraBundle\\Tests\\Fixtures\\Inheritance\\Horse';

        $this->assertTrue($graph->hasEdge(array(array($horseId, '__class__'), array($animalId, '__class__'))));
        $this->assertTrue($graph->hasEdge(array(array($frogId, '__class__'), array($animalId, '__class__'))));
    }
}
