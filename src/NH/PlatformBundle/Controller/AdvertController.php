<?php
// src/NH/PlatformBundle/Controller/AdvertController.php

namespace NH\PlatformBundle\Controller;

use NH\PlatformBundle\Entity\Advert;
use NH\PlatformBundle\Entity\AdvertSkill;
use NH\PlatformBundle\Entity\Application;
use NH\PlatformBundle\Entity\Image;
use NH\PlatformBundle\Form\AdvertType;

use NH\PlatformBundle\NHPlatformBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\HttpFoundation\RedirectResponse;
//use Symfony\Component\HttpFoundation\JsonResponse;

//le nom de notre contrôleur respecte le nom du fichier pour que l'autoload fonctionne

class AdvertController extends Controller
{
    /* public function affichageAction($id)
     {
         return new JsonResponse(array('id' => $id));
     }*/

    public function indexAction($page)
    {
        //comme on ne sait pas combien il y a de pages
        if ($page < 1) {
           //on déclenche une exception qui va afficher une page d'erreur
            throw new NotFoundHttpException('page ".$page."inexistante.');
       }
        //il faut fixer le nombre d'annonce par page

        $nbPerPage = 2;
        //pour récupérer la liste de toutes les annonces = findAll()

        //désormais on utilise getAdverts
        //il faut récupérer l'objet Paginator
        $listAdverts = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('NHPlatformBundle:Advert')
            ->getAdverts($page, $nbPerPage);
        //calcul du nbre total de pages = count
        $nbPages = ceil(count($listAdverts) / $nbPerPage);

        //on gère l'erreur 404
        if ($page > $nbPages) {
            throw $this->createNotFoundException("la page " . $page . "n'existe pas");
        }
        //on récupèrera la liste des annonces puis on la passera au template
        //on ne fait que l'appeler pour le moment
        //infos nécessaires à la vue
        return $this->render('NHPlatformBundle:Advert:index.html.twig', array(
            'listAdverts' => $listAdverts,
            'nbPages'     => $nbPages,
            'page'        => $page,
        ));
    }

//on appelle chaque fonction par le nom de son fichier
    public function viewAction($id)
    {
        //on récupère le repository
        $em = $this->getDoctrine()->getManager();

        //on récupère l'entité correspondante à l'id $id
        $advert = $em->getRepository('NHPlatformBundle:Advert')->find($id);
        //$advert est donc une instance de NH\PlatformBundle\Entity\Advert
        //ou null si l'id n'existe pas d'où ce if
        if (null === $advert) {
            throw new NotFoundHttpException("l'annonce d'id " .$id." n'existe pas.");
        }

        //on récupère la liste des candidatures de cette annonce
        $listApplications = $em
            ->getRepository('NHPlatformBundle:Application')
            ->findBy(array('advert' => $advert));
        $listAdvertSkills = $em
            ->getRepository('NHPlatformBundle:AdvertSkill')
            ->findBy(array('advert' => $advert));
        /*  $advert = array(
              'title' => 'recherche dév Symfony2',
              'id' => $id,
              'author' => 'Alexandre',
              'content' => 'Nous recherchons un dev Symfony debutantttttt....',
              'date' => new \DateTime()
          );*/

        //ici on récupère l'annonce qui correspond à l'id
        return $this->render('NHPlatformBundle:Advert:view.html.twig', array(
            'advert'           => $advert,
            'listApplications' => $listApplications,
            'listAdvertSkills' => $listAdvertSkills,
        ));
    }

    public function addAction(Request $request)
    { // On crée un objet Advert
        $advert = new Advert();
        $form = $this->get('form.factory')->create(AdvertType::class, $advert);

        //si la requête est en POST
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            //on fait le lien requête <--> formulaire
            //à partir de maintenant, la variable $advert contient
            // les valeurs entrées dans le form p/le visiteur

            //on vérifie que les valeurs entrées sont correctes
                //on enregistre notre objet $advert dans la bdd
                $em = $this->getDoctrine()->getManager();
                $em->persist($advert);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'annonce enregistrée');
                return $this->redirectToRoute('nh_platform_affichage', array('id' => $advert->getId()));
            }
        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        return $this->render('NHPlatformBundle:Advert:add.html.twig', array(
            'form' => $form->createView(),
        ));
        //AVANT
        /*    $em = $this->getDoctrine()->getManager();
            // On ne sait toujours pas gérer le formulaire, patience cela vient dans la prochaine partie !
            if ($request->isMethod('POST')) {
                $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

                return $this->redirectToRoute('nh_platform_affichage', array(
                    'id' => $advert->getId()));
            }
            return $this->render('NHPlatformBundle:Advert:add.html.twig');*/
        //FIN AVANT

    }

    /* $em = $this->getDoctrine()->getManager();
     //création de l'entité Advert
     $advert = new Advert();

     //on renseigne ses attributs
     $advert->setTitre('recherche dev symfony');
     $advert->setAuthor('Alex');
     $advert->setContent("un dev symfony debutant");
     $advert->setDate(new \Datetime());

     //on récupère toutes les compétences possibles
     $listSkills = $em->getRepository('NHPlatformBundle:Skill')->findAll();
     //pour chaque compétence
     foreach ($listSkills as $skill) {
         //on crée une nouvelle relation entre 1 annonce et 1 compétence
         $advertSkill = new AdvertSkill();
         // on la lie à l'annonce
         $advertSkill->setAdvert($advert);
         //on lie à la compétence, qui change ici dans la boucle
         $advertSkill->setSkill($skill);
         //arbitrairement on dit que chaque cptce est requise au niveau "expert"
         $advertSkill->setLevel('Expert');
         $em->persist($advertSkill);
     }
     //on ne peut pas définir ni la date ni la publication
     //car ces attributs sont définis automatiquement dans le constructeur

     //création de l'entité image
     $image = new Image();
     $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
     $image->setAlt('job de reve');

     //Création d'une première candidature
     $application1 = new Application();
     $application1->setAuthor('Ninou');
     $application1->setContent("j'ai toutes");

     //Création d'une 2nde candidature
     $application2 = new Application();
     $application2->setAuthor('Sacha');
     $application2->setContent("motivé motivé");

     //on lie l'image à l'annonce
     $advert->setImage($image);

     //on lie les candidatures à l'annonce
     $application1->setAdvert($advert);
     $application2->setAdvert($advert);

     // on récupère l'entitymanager
     $em = $this->getDoctrine()->getManager();
     //on persite l'entité
     $em->persist($advert);
     //on persiste tout à la main et non par cascade
     $em->persist($application1);
     $em->persist($application2);

     //on déclenche l'enregistrement de tout ce qui a été persisté avant
     $em->flush();

     //si la requête est en POST c'est que le visiteur a soumis le formulaire
     if ($request->isMethod('POST')) {
         //Ici on s'occupe de la CREATION et GESTION du formulaire
         $request->getSession()->getFlashBag()->add('notice', 'annonce enregistrée.');
         //on redirige vers la page de visualisation de l'annonce
         return $this->redirectToRoute('nh_platform_affichage', array('id' => $advert->getId()));
     }
     //si on n''est pas en POST = on affiche le formulaire
     return $this->render('NHPlatformBundle:Advert:ajout.html.twig');
 }*/
    
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère l'annonce $id
        $advert = $em->getRepository('NHPlatformBundle:Advert')->find($id);

        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
        $form = $this->get('form.factory')->create(AdvertType::class, $advert);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'annonce modifiée');
            return $this->redirectToRoute('nh_platform_view', array('id' => $advert->getId()));
        }
        return $this->render('NHPlatformBundle:Advert:edit.html.twig', array(
            'advert' => $advert,
            'form'   => $form->createView(),
        ));


       /* // La méthode findAll retourne toutes les catégories de la base de données
        $listCategories = $em->getRepository('NHPlatformBundle:Category')->findAll();

        // On boucle sur les catégories pour les lier à l'annonce
        foreach ($listCategories as $category) {
            $advert->addCategory($category);
        }
        $em->flush();

        // Pour persister le changement dans la relation, il faut persister l'entité propriétaire
        // Ici, Advert est le propriétaire, donc inutile de la persister car on l'a récupéré depuis Doctrine

        // Ici, on récupérera l'annonce correspondante à $id
        if ($request->isMethod('POST')) {
          // Étape 2 : On déclenche l'enregistrement
          $request->getSession()->getFlashBag()->add('notice', 'annonce modifiée');

          return $this->redirectToRoute('nh_platform_view', array('id' => $advert->getId()));
       }*/
      /* $advert = array(
            'title' => 'rech dev symfony',
            'id' => $id,
            'author' => 'Alex',
            'content' => 'Nous recherchons un dev symfony',
            'date' => new \Datetime()
            );*/
     /*   return $this->render('NHPlatformBundle:Advert:edit.html.twig', array(
            'advert' => $advert
        ));*/
    }

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        //on récupère l'annonce $id
        $advert = $em->getRepository('NHPlatformBundle:Advert')->find($id);

        if (null === $advert) {
            throw new NotFoundHttpException("l'annonce d'id ".$id." n'existe pas.");
        }
        // on crée un formulaire vide
        $form = $this->get('form.factory')->create();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($advert);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "annonce supprimée");
            return $this->redirectToRoute('nh_platfom_home');
        }

       return $this->render('NHPlatformBundle:Advert:delete.html.twig', array(
           'advert' => $advert,
           'form'   => $form->createView(),
       ));
    }

    public function menuAction($limit)
    {
        $em = $this->getDoctrine()->getManager();
        $listAdverts = $em->getRepository('NHPlatformBundle:Advert')->findBy(
            array(),                 // Pas de critère
            array('date' => 'desc'), // On trie par date décroissante
            $limit,                  // On sélectionne $limit annonces
            0                       // À partir du premier
        );
        return $this->render('NHPlatformBundle:Advert:menu.html.twig', array(
            'listAdverts' => $listAdverts
        ));
       /* //on fixe une liste ici pour la récupérer depuis la BDD
        $listAdverts = array(
            array('id' => 1, 'title' => 'Recuperation 12'),
            array('id' => 3, 'title' => 'recup de lid 13'),
            array('id' => 4, 'title' => 'recup de lid 14'),
        );
        return $this->render('NHPlatformBundle:Advert:menu.html.twig', array(
            //le contrôleur passe ici les variables nécessaires au TEMPLATE
            'listAdverts' => $listAdverts
        ));*/
    }

    public function testAction()
    {
        $advert = new Advert();
        $advert->setTitre("rech dévelop");
        $advert->setAuthor("nad");
        $advert->setContent("tester");

        $em = $this->getDoctrine()->getManager();
        $em->persist($advert);
        $em->flush();// c'est à ce moment qu'est généré le slug

        return new Response('Slug généré : '.$advert->getSlug());
        return new Response('Slug généré : '.$advert->getSlug());

        //affiche "slug généré : recherche-developp"
    }

    // on définit la méthode indexAction()
//   public function indexAction()
//
    /* {
         //on récupère ici le contenu du template
         $content = $this
             ->get('templating')
             ->render('NHPlatformBundle:Advert:index.html.twig', array('nom' => 'nad'));
         //on crée une réponse toute simple
         //on passe une nouvelle variable $content à la place de notre "hello world" écrit à la main
         return new Response($content);
     }*/

   /* public function affichageAction($id, Request $request)
    {
        {
            //on veut avoir l'URL de l'annonce d'id 5
            $url = $this->get('router')->generate(
                'nh_platform_affichage',//1er argument : le nom de la route
                array('id' => 5)//2nd argument : les valeurs des paramètres
            );
            return new Response("l'url de l'annonce d'id 5 est : " . $url);
        }*/
        //$url vaut "/platform/advert/5"*/

//récupération et affichage de l'id dans l'url
//on injecte la requête dans les arguments de la méthode
//   public function affichageAction($id, Request $request)
//    {
        //ainsi on a accès à la requête HTTP via $request


//on récupère notre paramètre tag
//request->query pour récupérer les params de l'URL passés en GET
        /*$tag = $request->query->get('tag');
        //le contrôleur lui même dispose d'un raccourci pour utilier la méthode
        //renderResponse = Render
        return $this->render('NHPlatformBundle:Advert:view.html.twig', array(
            'id' => $id,
                'tag' => $tag,
        ));
//  "affichage de l'annonce d'id : ".$id.", avec le tag : ".$tag
//       );
        }
// $id vaut 10 si on appelle l'URL /platform/avert/10*/
//  return new Response("affichage de l'id : ".$id);

    }

