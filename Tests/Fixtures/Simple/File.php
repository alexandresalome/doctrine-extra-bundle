<?php

namespace Alex\DoctrineExtraBundle\Tests\Fixtures\Simple;

/**
 * @Entity
 */
class File
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Folder", inversedBy="files")
     * @JoinColumn
     */
    private $folder;

    /**
     * @Column(type="string", length=32)
     */
    private $name;
}
