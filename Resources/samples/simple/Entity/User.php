<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

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
