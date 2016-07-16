<?php

namespace Alex\DoctrineExtraBundle\Tests\Fixtures\Simple;

/**
 * @Entity
 */
class User
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @OneToMany(targetEntity="Folder", mappedBy="user")
     */
    private $folders;

    /**
     * @Column(type="string", length=32)
     */
    private $username;

    /**
     * @Column(type="string", length=128)
     */
    private $fullname;

    /**
     * @Column(type="string", length=255)
     */
    private $email;
}
