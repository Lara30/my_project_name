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
            ->render('NHPlatformBundle:Advert:index.html.twig', array ('nom' => 'nad'));
        //on crée une réponse toute simple
        //on passe une nouvelle variable $content à la place de notre "hello world" écrit à la main
        return new Response($content);
    }

    public function secondepageAction()
    {
        $valeur = $this
            ->get('templating')
            ->render('NHPlatformBundle:Advert:secondepage.html.twig');
        return new Response($valeur);
    }
}