<?php
// src/NH/PlatformBundle/Entity/Advert.php
namespace NH\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

//on utilise le namespace de l'annotation
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Advert
 *
 * @ORM\Table(name="nh_advert")
 * @ORM\Entity(repositoryClass="NH\PlatformBundle\Repository\AdvertRepository")
 * @ORM\HasLifecycleCallbacks()
 */
//l'annotation Haslife permet à doctrine de vérifier les callbacks éventuels contenus dans l'entité
class Advert
{
     /**
      * @var int
      * @ORM\Column(name="id", type="integer")
      * @ORM\Id
      * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
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
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = true;

    //l'entité advert est propriétaire de la relation
    /**
     * @ORM\OneToOne(targetEntity="NH\PlatformBundle\Entity\Image", cascade={"persist", "remove"})
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

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(name="nb_applications", type="integer")
     */
    private $nbApplications = 0;


//l'annotation Slug s'applique simplement sur un attribut qui va contenir le sluf
//l'option fields permet de définir les attributs à partir desquels le slug sera généré :
// ici le titre uniquement
    /**
     * @Gedmo\Slug(fields={"titre"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;


    //comme la propriété $categories doit être un arraycollection,
    //on doit la définir dans un constructeur :
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->date         = new \DateTime();
        $this->categories   = new ArrayCollection();
        $this->applications = new ArrayCollection();
    }
    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    public function increaseApplication()
    {
        $this->nbApplications++;
    }

    public function decreaseApplication()
    {
        $this->nbApplications--;
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
     * Get date
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
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

    /**
     * Set image
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
     * @return Image
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

    /**
     * @param Application $application
     */
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

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\Datetime $updatedAt = null)
    {
        $this->updatedAt = $updatedAt;
    }
    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    /**
     * @param integer $nbApplications
     */
    public function setNbApplications($nbApplications)
    {
        $this->nbApplications = $nbApplications;
    }

    /**
     * @return integer
     */
    public function getNbApplications()
    {
        return $this->nbApplications;
    }

    /**
     * Set slug
     * @param string $slug
     * @return Advert
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
//        return $this;
    }

    /**
     * Get slug
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
