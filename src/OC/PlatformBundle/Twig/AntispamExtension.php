<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OC\PlatformBundle\Twig;

use OC\PlatformBundle\Antispam\OCAntispam;
use Twig_Extension;
use Twig_SimpleFunction;

class AntispamExtension extends Twig_Extension {

    private $ocAntispam;

    public function __construct(OCAntispam $ocAntispam) {
        $this->ocAntispam = $ocAntispam;
    }
    
    public function checkIfArgumentIsSpam($text) {
        return $this->ocAntispam->isSpam($text);
    }

    public function getName() {
        return "OCAntispam";
    }
    
    public function getFunctions() {
        return array(
            new Twig_SimpleFunction("checkIfSpam", array($this, "checkIfArgumentIsSpam"))
        );
    }

}
