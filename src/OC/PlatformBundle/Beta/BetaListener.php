<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OC\PlatformBundle\Beta;

/**
 * Description of BetaListener
 *
 * @author nicol
 */
class BetaListener {
    //Notre processeur
    protected $betaHTML;
    
    //Date de fin de la version beta
    protected $endDate;
    
    public function __construct(BetaHTMLAdder $betaHTML, $endDate) {
        $this->betaHTML = $betaHTML;
        $this->endDate = new \DateTime($endDate);
    }
    
    public function processBeta(\Symfony\Component\HttpKernel\Event\FilterResponseEvent $event) {
        if(!$event->isMasterRequest()) {
            return;
        }
                
        $remainingDays = $this->endDate->diff(new \DateTime())->days;
        
        if($remainingDays >= 0) {
            return;
        }
        
        $response = $this->betaHTML->addBeta($event->getResponse(), $remainingDays);
        
        $event->setResponse($response);
    }
}
