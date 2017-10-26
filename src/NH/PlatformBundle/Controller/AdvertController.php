<?php
// src/NH/PlatformBundle/Controller/AdvertController.php

namespace NH\PlatformBundle\Controller;

use NH\PlatformBundle\Entity\Advert;
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
        //création de l'entité
        $advert = new Advert();

        //on renseigne ses attributs
        $advert->setTitre('recherche dev symfony');
        $advert->setAuthor('Alex');
        $advert->setContent("un dev symfony debutant");
        $advert->setDate(new \Datetime());

        //création de l'entité image
        $image = new Image();
        $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
        $image->setAlt('job de reve');
        //on lie l'image à l'annonce
        $advert->setImage($image);
        //on ne peut pas définir ni la date ni la publication
        //car ces attributs sont définis automatiquement dans le constructeur

        // on récupère l'entitymanager
        $em = $this->getDoctrine()->getManager();
        //on persite l'entité
        $em->persist($advert);
        //on déclenche l'enregistrement
        $em->flush();

        //si la requête est en POST c'est que le visiteur a soumis le formulaire
        if ($request->isMethod('POST')) {
            //Ici on s'occupe de la CREATION et GESTION du formulaire
            $request->getSession()->getFlashBag()->add('notice', 'annonce enregistrée.');
            //on redirige ver sla page de visualisation de l'annonce
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
        /*  $advert = array(
              'title' => 'recherche dév Symfony2',
              'id' => $id,
              'author' => 'Alexandre',
              'content' => 'Nous recherchons un dev Symfony debutantttttt....',
              'date' => new \DateTime()
          );*/

        //ici on récupère l'annonce qui correspond à l'id
        return $this->render('NHPlatformBundle:Advert:view.html.twig', array(
            'advert' => $advert
        ));
    }
    public function editAction($id, Request $request)
    {
//        if ($request->isMethod('POST')) {
        $advert = array(
            'title' => 'rech dev symfony',
            'id' => $id,
            'author' => 'Alex',
            'content' => 'Nous recherchons un dev symfony',
            'date' => new \Datetime(),
            );
//            $request->getSession()->getFlashBag()->add('notice', 'annonce modifiée.');
//            return $this->redirectToRoute('nh_platform_view', array('id' => 3));
        return $this->render('NHPlatformBundle:Advert:edit.html.twig', array(
            'advert' => $advert
        ));
    }

    public function deleteAction($id)
    {
        return $this->render('NHPlatformBundle:Advert:delete.html.twig');
    }

    public function menuAction($limit)
    {
        //on fixe une liste ici pour la récupérer depuis la BDD
        $listAdverts = array(
            array('id' => 9, 'title' => 'Test1'),
            array('id' => 10, 'title' => 'Test2'),
            array('id' => 11, 'title' => 'Test3'),
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

