<?php
// src/NH/PlatformBundle/Entity/Advert.php
namespace NH\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Advert
 *
 * @ORM\Table(name="advert")
 * @ORM\Entity(repositoryClass="NH\PlatformBundle\Repository\AdvertRepository")
 */

class Advert
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    //l'entité advert est propriétaire de la relation
    /**
     * @ORM\OneToOne(targetEntity="NH\PlatformBundle\Entity\Image", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


    //test selon le tuto
    /**
     * @ORM\Column(name="published", type="boolean")
     */

    /**
     * Get id
     *
     * @return int
     */

    /**
     * @ORM\Column(name="published", type="boolean")
     * @return int
     */
    private $published = true;

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Advert
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Advert
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Advert
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Advert
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get content
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set published
     * @param boolean $published
     * @return Advert
     */
    public function setPublished($published)
    {
        $this->published = $published;
        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**set image
     *
     * @param Image|null $image
     * @return Advert
     *
     */
    public function setImage(Image $image = null)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * Get image
     *
     * @return \NH\PlatformBundle\Entity\Image
     */

    public function getImage()
    {
        return $this->image;
    }

}
