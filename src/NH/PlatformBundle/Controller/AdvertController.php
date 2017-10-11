<?php

// src/NH/PlatformBundle/Controller/AdvertController.php

namespace NH\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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


//récupération et affichage de l'id dans l'url
    public function affichageAction($id)
    {
//        /*$id vaut 10 si on appelle l'URL /platform/avert/10*/
        return new Response("affichage de l'id : ".$id);
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

