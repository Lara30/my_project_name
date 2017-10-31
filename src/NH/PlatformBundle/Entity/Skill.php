<?php
// src/NH/PlatformBundle/Entity/Skill.php

namespace NH\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**

 * @ORM\Entity
 * @ORM\Table(name="nh_skill")
 */

class Skill
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

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}