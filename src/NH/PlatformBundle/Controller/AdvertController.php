<?php

// src/NH/PlatformBundle/Controller/AdvertController.php

namespace NH\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

//le nom de notre contrôleur respecte le nom du fichier pour que l'autoload fonctionne
class AdvertController extends Controller
{
    // on définit la méthode indexAction()
    public function indexAction()
    {
        //on récupère ici le contenu du template
        $content = $this
            ->get('templating')
            ->render('NHPlatformBundle:Advert:index.html.twig', array('nom' => 'nad'));
        //on crée une réponse toute simple
        //on passe une nouvelle variable $content à la place de notre "hello world" écrit à la main
        return new Response($content);
    }

    //cette méthode Testaction permet de rediriger vers l'accueil
    public function testAction($id)
    {
        $url = $this->get('router')->generate('nh_platform_home');
        //cela peut s'écrire sous plusieurs formes :

//        return new RedirectResponse($url);
//        return $this->redirect($url);
        return $this->redirectToRoute('nh_platform_home');
        //la méthode redirectToRoute prend directement en argument la route vers laquelle rediriger et non l'url
    }
    public function affichageAction($id, Request $request)
    {
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
        $tag = $request->query->get('tag');
        //le contrôleur lui même dispose d'un raccourci pour utilier la méthode
        //renderResponse = Render
        return $this->render('NHPlatformBundle:Advert:view.html.twig', array(
            'id' => $id,
                'tag' => $tag,
        ));
//  "affichage de l'annonce d'id : ".$id.", avec le tag : ".$tag
//       );
// $id vaut 10 si on appelle l'URL /platform/avert/10*/
//  return new Response("affichage de l'id : ".$id);
    }

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

