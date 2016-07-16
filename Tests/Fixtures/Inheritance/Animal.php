<?php

namespace Alex\DoctrineExtraBundle\Tests\Fixtures\Inheritance;

/**
 * @MappedSuperClass
 */
abstract class Animal
{
    /**
     * @Id
     * @Column(type="integer")
     */
    private $id;

    /**
     * @Column(type="integer")
     */
    private $paws;
}
