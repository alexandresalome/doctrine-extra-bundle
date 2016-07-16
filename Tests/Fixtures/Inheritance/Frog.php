<?php

namespace Alex\DoctrineExtraBundle\Tests\Fixtures\Inheritance;

/**
 * @Entity
 */
class Frog extends Animal
{
    /**
     * @Column(type="string", length=32)
     */
    private $color;
}
