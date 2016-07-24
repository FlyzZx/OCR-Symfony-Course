<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OC\PlatformBundle\DataFixtures\ORM;

use DateTime;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Application;

/**
 * Description of LoadAdvert
 *
 * @author nicol
 */
class LoadAdvert implements FixtureInterface {
    public function load(ObjectManager $manager) {
        for($i = 1; $i <= 10; $i++) {
            $advert = new Advert();
            $advert->setAuthor("Auteur " . $i);
            $advert->setContent("Contenu de l'annonce numéro " . $i);
            $advert->setTitle("Titre de l'annonce numéro " . $i);
            $advert->setEmail("utilisateur" . $i . "@test.fr");
            $date = new DateTime();
            $date->modify("-" . $i . " day");
            $advert->setDate($date);
            
            if ($i % 2) {
                $application = new Application();
                $application->setAuthor("Auteur de la candidature numéro " . $i);
                $application->setContent("Contenu de la candidature numéro " . $i);
                $application->setAdvert($advert);
                $manager->persist($application);
            }        
            $manager->persist($advert);
        }
        
        $manager->flush();
    }
}
