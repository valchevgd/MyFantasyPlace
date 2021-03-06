<?php

namespace MyFantasyPlaceBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping;
use MyFantasyPlaceBundle\Entity\Role;

/**
 * RoleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RoleRepository extends \Doctrine\ORM\EntityRepository
{

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new Mapping\ClassMetadata(Role::class));
    }
}
