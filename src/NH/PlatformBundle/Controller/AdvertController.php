<?php
// src/NH/PlatformBundle/Controller/AdvertController.php

namespace NH\PlatformBundle\Controller;

use NH\PlatformBundle\Entity\Advert;
use NH\PlatformBundle\Entity\Application;
use NH\PlatformBundle\Entity\Image;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        if ($page < 0) {
            //on déclenche une exception qui va afficher une page d'erreur
            throw new NotFoundHttpException('Page"' . $page . '" inexistante.');
        }
        //on récupèrera la liste des annonces puis on la passera au template
        //on ne fait que l'appeler pour le moment
        return $this->render('NHPlatformBundle:Advert:index.html.twig', array(
            'listAdverts' => array(
                array(
                    'title' => 'Recherche développpeur Symfony',
                    'id' => 1,
                    'author' => 'Alexandre',
                    'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon',
                    'date' => new \Datetime()),

                array(
                    'title' => 'Mission de webmaster',
                    'id' => 2,
                    'author' => 'Hugo',
                    'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet',
                    'date' => new \Datetime()),

                array(
                    'title' => 'Offre de stage webdesigner',
                    'id' => 3,
                    'author' => 'Mathieu',
                    'content' => 'Nous proposons un poste pour webdesigner',
                    'date' => new \Datetime()),
            )));
    }

    public function addAction(Request $request)
    {
        //création de l'entité Advert
        $advert = new Advert();

        //on renseigne ses attributs
        $advert->setTitre('recherche dev symfony');
        $advert->setAuthor('Alex');
        $advert->setContent("un dev symfony debutant");
        $advert->setDate(new \Datetime());
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
        return $this->render('NHPlatformBundle:Advert:add.html.twig', array('advert' => $advert));
    }

//on appelle chaque fonction par le nom de son fichier
    public function viewAction($id)
    {
        //on récupère le repository
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('NHPlatformBundle:Advert');

        //on récupère l'entité correspondante à l'id $id
        $advert = $repository->find($id);
        //$advert est donc une instance de NH\PlatformBundle\Entity\Advert
        //ou null si l'id n'existe pas d'où ce if
        if (null === $advert) {
            throw new NotFoundHttpException("l'annonce d'id " . $id . "n'existe pas.");
        }

        //on récupère la liste des candidatures de cette annonce
        /*$listApplications = $repository
            ->getRepository('NHPlatformBundle:Application')
            ->findBy(array('advert' => $advert))
            ;*/
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
//            'listApplications' => $listApplications
        ));
    }


    public function editAction($id, Request $request)
    {
 /*       $em = $this->getDoctrine()->getManager();
        // On récupère l'annonce $id
        $advert = $em->getRepository('GCPlatformBundle:Advert')->find($id);
        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
        // La méthode findAll retourne toutes les catégories de la base de données
        $listCategories = $em->getRepository('GCPlatformBundle:Category')->findAll();
        // On boucle sur les catégories pour les lier à l'annonce
        foreach ($listCategories as $category) {
            $advert->addCategory($category);
        }
        // Pour persister le changement dans la relation, il faut persister l'entité propriétaire
        // Ici, Advert est le propriétaire, donc inutile de la persister car on l'a récupérée depuis Doctrine
        // Étape 2 : On déclenche l'enregistrement
        $em->flush();
        // Ici, on récupérera l'annonce correspondante à $id
       if ($request->isMethod('POST')) {
           $request->getSession()->getFlashBag()->add('notice', 'annonce modifiée');

           return $this->redirectToRoute('nh_platform_view', array('id' => 3));
       }*/
       $advert = array(
            'title' => 'rech dev symfony',
            'id' => $id,
            'author' => 'Alex',
            'content' => 'Nous recherchons un dev symfony',
            'date' => new \Datetime()
            );
        return $this->render('NHPlatformBundle:Advert:edit', array(
            'advert' => $advert
        ));
    }

    public function deleteAction($id)
    {
        return $this->render('NHPlatformBundle:Advert:delete');
    }

    public function menuAction($limit)
    {
        //on fixe une liste ici pour la récupérer depuis la BDD
        $listAdverts = array(
            array('id' => 17, 'title' => 'Recuperation 17'),
            array('id' => 18, 'title' => 'recup de lid'),
            array('id' => 19, 'title' => 'recup de lid 19'),
        );
        return $this->render('NHPlatformBundle:Advert:menu.html.twig', array(
            //le contrôleur passe ici les variables nécessaires au TEMPLATE
            'listAdverts' => $listAdverts
        ));
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

