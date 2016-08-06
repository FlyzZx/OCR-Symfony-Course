<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OC\PlatformBundle\Beta;

use Symfony\Component\HttpFoundation\Response;

/**
 * Description of BetaHTMLAdder
 *
 * @author nicol
 */
class BetaHTMLAdder {

    //Methode d'ajout du beta a une réponse

    public function addBeta(Response $response, $remainingDays) {
        $content = $response->getContent();

        // Code à rajouter
        // (Je mets ici du CSS en ligne, mais il faudrait utiliser un fichier CSS bien sûr !)
        $html = '<div style="position: absolute; top: 0; background: orange; width: 100%; text-align: center; padding: 0.5em;">Beta J-' . (int) $remainingDays . ' !</div>';
        $content = str_replace("<body>", "<body> " . $html, $content);
        
        $response->setContent($content);
        
        return $response;
    }

}
