<?php

namespace NH\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    public function indexAction()
    {
        return $this->render('NHCoreBundle:Core:index.html.twig');
    }

    // La page de contact
    public function contactAction(Request $request)
    {
        // On récupère la session depuis la requête, en argument du contrôleur
        $session = $request->getSession();
        // Et on définit notre message
        $session->getFlashBag()->add('info', 'La page de contact n’est pas encore disponible, merci de revenir plus tard.');
        // Enfin, on redirige simplement vers la page d'accueil
        return $this->redirectToRoute('nh_core_home');
        // La méthode longue new RedirectResponse($this->get('router')->generate('oc_core_home')); est parfaitement valable
    }
}
