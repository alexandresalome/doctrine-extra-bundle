<?php

namespace Alex\DoctrineExtraBundle\Tests\Fixtures\Simple;

/**
 * @Entity
 */
class Folder
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="folders")
     * @JoinColumn
     */
    private $user;

    /**
     * @OneToMany(targetEntity="File", mappedBy="folder")
     * @JoinColumn
     */
    private $files;

    /**
     * @Column(type="string", length=32)
     */
    private $name;
}
