<?php
// src/NH/PlatformBundle/Entity/Advert.php
namespace NH\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
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
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = true;

    //l'entité advert est propriétaire de la relation
    /**
     * @ORM\OneToOne(targetEntity="NH\PlatformBundle\Entity\Image", cascade={"persist"})
     * @ORM\JoinColumn
     */
    private $image;
//le proprio d'une relation Many-to-One est toujours le côté Many
    /**
     * @ORM\ManyToMany(targetEntity="NH\PlatformBundle\Entity\Category", cascade={"persist"})
     * @ORM\JoinTable(name="nh_advert_category")
     */
    private $categories;
//ce n'est pas une reltion propriétaire donc One-to-Many
//le mappedBy correspond à l'attribut de l'entité proprio qui pointe vers l'entité inverse "le private $advert"
    /**
     * @ORM\OneToMany(targetEntity="NH\PlatformBundle\Entity\Application", mappedBy="advert")
     */
    private $applications;

    //comme la propriété $categories doit être un arraycollection,
    //on doit la définir dans un constructeur :
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories   = new ArrayCollection();
        $this->applications = new ArrayCollection();
    }

    /**
     * Get id
     * @return int
     */
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
//        return $this;
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
//        return $this;
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
//        return $this;
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
//        return $this;
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

     */
    public function setImage(Image $image = null)
    {
        $this->image = $image;
//        return $this;
    }

    /**
     * Get image
     * @return \NH\PlatformBundle\Entity\Image
     */

    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add category
     * @param Category $category
     * @return Advert
     */
    //on ajoute une seule Categorie à la fois
    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
//        return $this;
    }

    /**
     * Remove category
     *
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        //ici on utilise une méthode de l'arraycollection pour supprimer la catégorie en argument
        $this->categories->removeElement($category);
    }

    /**
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add application
     *
     * @param Application $application
     * @return Advert
     */

    public function addApplication(Application $application)
    {
        $this->applications[] = $application;
        // On lie l'annonce à la candidature
        $application->setAdvert($this);
//        return $this;
    }

    public function removeApplication(Application $application)
    {
        $this->applications->removeElement($application);
//        et si notre relation était facultative
//        $application->setAdvert(null);
    }
    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApplications()
    {
        return $this->applications;
    }
}
