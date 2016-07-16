<?php

namespace Alex\DoctrineExtraBundle\Tests\Fixtures\Inheritance;

/**
 * @Entity
 */
class Horse extends Animal
{
    /**
     * @ORM\Column(type="string", length=32)
     */
    private $tailColor;
}
