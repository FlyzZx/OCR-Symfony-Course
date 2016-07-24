<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OC\PlatformBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of CategoryRepository
 *
 * @author nicol
 */
class CategoryRepository extends EntityRepository{
    /**
     * 
     * @param string $pattern
     * @return QueryBuilder
     */
    public function getLikeQueryBuilder($pattern) {
        return $this->createQueryBuilder("c")
                ->where("c.name LIKE :pattern")
                ->setParameter("pattern", $pattern);
    }
}
