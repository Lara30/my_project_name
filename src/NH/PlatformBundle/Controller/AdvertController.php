<?php

// src/NH/PlatformBundle/Controller/AdvertController.php

namespace NH\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;*/
//use Symfony\Component\HttpFoundation\JsonResponse;

//le nom de notre contrôleur respecte le nom du fichier pour que l'autoload fonctionne
class AdvertController extends Controller
{
   /* public function affichageAction($id)
    {
        return new JsonResponse(array('id' => $id));
    }*/

   public function indexAction($page)
   {//comme on ne sait pas combien il y a de pages
       if ($page < 0) {
           //on déclenche une exception qui va afficher une page d'erreur
           throw new NotFoundHttpException('Page"'.$page.'" inexistante.');
       }
       //on récupèrera la liste des annonces puis on la passera au template
       //on ne fait que l'appeler pour le moment
      return $this->render('NHPlatformBundle:Advert:index.html.twig', array(
           'listAdverts' => array(
               array(
                   'title'   => 'Recherche développpeur Symfony',
                   'id'      => 1,
                   'author'  => 'Alexandre',
                   'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                   'date'    => new \Datetime()),

               array(
                   'title'   => 'Mission de webmaster',
                   'id'      => 2,
                   'author'  => 'Hugo',
                   'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                   'date'    => new \Datetime()),

               array(
                   'title'   => 'Offre de stage webdesigner',
                   'id'      => 3,
                   'author'  => 'Mathieu',
                   'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
                   'date'    => new \Datetime())
           )));
   }

   public function viewAction($id)
   {
       $advert = array(
           'title' => 'recherche dév Symfony2',
           'id' => $id,
           'author' => 'Alexandre',
           'content' => 'Nous recherchons un dev Symfony2 débutant....',
           'date' => new \DateTime()
       );
       //ici on récupère l'annonce qui correspond à l'id
       return $this->render('NHPlatformBundle:Advert:view.html.twig', array(
           'advert' => $advert
       ));
   }

    public function addAction(Request $request)
    {
        //si la requête est en POST c'est que le visiteur a soumis le formulaire
        if ($request->isMethod('POST')) {
            //Ici on s'occupe de la CREATION et GESTION du formulaire
            $request->getSession()->getFlashBag()->add('notice', 'annonce enregistrée.');
            //on redirige ver sla page de visualisation de l'annonce
            return $this->redirectToRoute('nh_platform_view', array('id' => 6));
        }
        //si on n''est pas en POST = on affiche le formulaire
        return $this->render('NHPlatformBundle:Advert:add.html.twig');
    }

    public function editAction($id, Request $request)
    {
        if ($request->isMethod('POST')) {

            $request->getSession()->getFlashBag()->add('notice', 'annonce modifiée.');
            return $this->redirectToRoute('nh_platform_view', array('id' => 3));
        }
        return $this->render('NHPlatformBundle:Advert:edit.html.twig');
    }

    public function deleteAction($id)
    {
        return $this->render('NHPlatformBundle:Advert:delete.html.twig');
    }

    public function menuAction($limit)
    {
        //on fixe une liste ici pour la récupérer depuis la BDD
        $listAdverts = array(
            array('id' => 2, 'title' => 'Test1'),
            array('id' => 3, 'title' => 'Test2'),
            array('id' => 7, 'title' => 'Test3'),
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

    //cette méthode Testaction permet de rediriger vers l'accueil
   /* public function testAction($id)
    {
        $url = $this->get('router')->generate('nh_platform_home');
        //cela peut s'écrire sous plusieurs formes :

//        return new RedirectResponse($url);
//        return $this->redirect($url);
        return $this->redirectToRoute('nh_platform_home');
        //la méthode redirectToRoute prend directement en argument la route vers laquelle rediriger et non l'url
    }

    public function affichageAction($id, Request $request)
    {*/
        /*  {
              //on veut avoir l'URL de l'annonce d'id 5
              $url = $this->get('router')->generate(
                  'nh_platform_affichage',//1er argument : le nom de la route
                  array('id' => 5)//2nd argument : les valeurs des paramètres
              );
              return new Response("l'url de l'annonce d'id 5 est : ".$url);
          }*/
        //$url vaut "/platform/advert/5"

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


    //récupération avec plusieurs paramètres
    public function affichageParamsAction($params, $year, $format)
    {
        return new Response(
//            on récupère tous les params en arguments de la méthode
        //on peut sépare les params soit avec le /, soit avec le .
            "on affiche les paramètres ".$params.", créée en ".$year." et au format ".$format."."
    );
    }


    public function secondepageAction()
    {
        $valeur = $this
            ->get('templating')
            ->render('NHPlatformBundle:Advert:secondepage.html.twig');
        return new Response($valeur);
    }
}

