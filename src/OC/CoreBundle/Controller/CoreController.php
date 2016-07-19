<?php

namespace OC\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of CoreController
 *
 * @author nicol
 */
class CoreController extends Controller {

    public function indexAction() {
        return $this->render("OCCoreBundle:Core:home.html.twig");
    }
    
    public function contactAction(Request $request) {
       $session = $request->getSession();
       
       $session->getFlashBag()->add("info", "La page de contact sera disponible ultérieurement :-) !");
       
       return $this->redirectToRoute("oc_core_home");
    }

}
