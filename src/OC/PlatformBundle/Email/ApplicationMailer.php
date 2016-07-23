<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OC\PlatformBundle\Email;

use OC\PlatformBundle\Entity\Application;
use Swift_Mailer;
use Swift_Message;


/**
 * Description of ApplicationMailer
 *
 * @author nicol
 */
class ApplicationMailer {

    /**
     * @var Swift_Mailer
     */
    private $mailer;

    public function __construct(Swift_Mailer $mailer) {
        $this->mailer = $mailer;
    }

    public function sendNewNotification(Application $application) {
        $message = new Swift_Message("Nouvelle candidature", "Vous avez reçu une nouvelle candidature.");
        $message->addTo($application->getAdvert()->getAuthor())->addFrom("admin@occourse.fr");
        $this->mailer->send($message);
    }

}
