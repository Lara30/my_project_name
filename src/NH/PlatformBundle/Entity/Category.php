<?php
// src/NH/PlatformBundle/Entity/Category.php

namespace NH\PlatformBundle\Entity;
use NH\PlatformBundle\Repository\AdvertRepository;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="nh_category")
 * @ORM\Entity(repositoryClass="NH\PlatformBundle\Repository\CategoryRepository")
 */

class Category
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */

    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}