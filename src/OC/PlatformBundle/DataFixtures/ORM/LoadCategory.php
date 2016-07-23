<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OC\PlatformBundle\DateFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Category;

/**
 * Description of LoadCategory
 *
 * @author nicol
 */
class LoadCategory implements FixtureInterface {

    public function load(ObjectManager $manager) {
        // Liste des noms de catégorie à ajouter
        $names = array(
            'Développement web',
            'Développement mobile',
            'Graphisme',
            'Intégration',
            'Réseau'
        );
        
        foreach($names as $name) {
            $category = new Category();
            $category->setName($name);
            
            $manager->persist($category);
        }
        
        $manager->flush();
    }

}
