<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OC\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of SecurityController
 *
 * @author nicol
 */
class SecurityController extends Controller {
    public function loginAction() {
        //Si le visiteur est déjà authentifié
        if($this->get("security.authorization_checker")->isGranted("IS_AUTHENTIFICATED_REMEMBERED")) {
            return $this->redirectToRoute("oc_platform_home");
        }
        
        $authentificationUtilis = $this->get("security.authentication_utils");
        
        return $this->render("OCUserBundle:Security:login.html.twig", array(
           "last_username" => $authentificationUtilis->getLastUsername(),
            "error" => $authentificationUtilis->getLastAuthenticationError()
        ));
    }
}
