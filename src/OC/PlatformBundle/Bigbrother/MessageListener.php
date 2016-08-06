<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OC\PlatformBundle\Bigbrother;

use OC\PlatformBundle\Event\MessagePostEvent;

/**
 * Description of MessageListener
 *
 * @author nicol
 */
class MessageListener {
    protected $notificator;
    protected $listUser = array();
    
    function __construct(MessageNotificator $notificator, $listUser) {
        $this->notificator = $notificator;
        $this->listUser = $listUser;
    }
    
    public function processMessage(MessagePostEvent $event) {
        if(in_array($event->getUser()->getUsername(), $this->getUser())) {
            $this->notificator->notifyByEmail($event->getMessage(), $event->getUser());
        }
    }

}
