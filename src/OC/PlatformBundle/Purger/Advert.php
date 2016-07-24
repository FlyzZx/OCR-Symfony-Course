<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace OC\PlatformBundle\Purger;

use Doctrine\ORM\EntityManager;
/**
 * Description of Advert
 *
 * @author nicol
 */
class Advert {
    
    /**
     * @var EntityManager
     */
    private $em;
    
    /**
     * 
     * @param EntityManager $em
     */    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function purge($days) {
        $repo = $this->em->getRepository("OCPlatformBundle:Advert");
        $oldsAdverts = $repo->getOldAdvertsWithoutApplications($days);
        
        foreach($oldsAdverts as $advert) {
            $this->em->remove($advert);
        }
        
        $this->em->flush();
    }
}
