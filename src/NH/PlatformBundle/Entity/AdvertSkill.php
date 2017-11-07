<?php
// src/NH/PlatformBundle/Entity/AdvertSkill.php

namespace NH\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="nh_advert_skill")
 */

class AdvertSkill
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="level", type="string", length=255)
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="NH\PlatformBundle\Entity\Advert")
     * @ORM\JoinColumn(nullable=false)
     */
    private $advert;

    /**
     * @ORM\ManyToOne(targetEntity="NH\PlatformBundle\Entity\Skill")
     * @ORM\JoinColumn(nullable=false)
     */
    private $skill;

    // ... on peut ajouter d'autres attributs

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set level
     *
     * @param string $level
     *
     * @return AdvertSkill
     */
    public function setLevel($level)
    {
        $this->level = $level;
//        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set advert
     *
     * @param Advert $advert
     *
     * @return AdvertSkill
     */
    public function setAdvert(Advert $advert)
    {
        $this->advert = $advert;
//        return $this;
    }

    /**
     * Get advert
     *
     * @return Advert
     */
    public function getAdvert()
    {
        return $this->advert;
    }

    /**
     * Set skill
     *
     * @param Skill $skill
     *
     * @return AdvertSkill
     */
    public function setSkill(Skill $skill)
    {
        $this->skill = $skill;
//        return $this;
    }

    /**
     * Get skill
     *
     * @return Skill
     */
    public function getSkill()
    {
        return $this->skill;
    }
}
