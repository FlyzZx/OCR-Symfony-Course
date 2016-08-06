<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OC\PlatformBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Description of MessagePostEvent
 *
 * @author nicol
 */
class MessagePostEvent extends Event {
    protected $message;
    protected $user;
    
    function __construct($message, $user) {
        $this->message = $message;
        $this->user = $user;
    }

    function getMessage() {
        return $this->message;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function getUser() {
        return $this->user;
    }


}
