<?php
// src/NH/PlatformBundle/Entity/Application.php

namespace NH\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="nh_application")
 * @ORM\Entity(repositoryClass="NH\PlatformBundle\Entity\ApplicationRepository")
 */

class Application
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="NH\PlatformBundle\Entity\Advert", inversedBy="applications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $advert;

    public function __construct()
    {
        $this->date = new \Datetime();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $author
     * @return $this
     */
    public function setAuthor($author)
    {
        $this->author = $author;
//        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
//        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param \Datetime
     * @return $this
     */
    public function setDate(\Datetime $date)
    {
        $this->date = $date;
//        return $this;
    }

    /**
     * @return \Datetime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set advert
     *
     * @param \NH\PlatformBundle\Entity\Advert $advert
     *
     * @return Application
     */
    public function setAdvert(\NH\PlatformBundle\Entity\Advert $advert)
    {
        $this->advert = $advert;
    }

    /**
     * Get advert
     *
     * @return \NH\PlatformBundle\Entity\Advert
     */
    public function getAdvert()
    {
        return $this->advert;
    }
}
