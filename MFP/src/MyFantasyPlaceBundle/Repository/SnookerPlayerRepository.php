<?php

namespace MyFantasyPlaceBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping;
use MyFantasyPlaceBundle\Entity\SnookerPlayer;

/**
 * SnookerPlayerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SnookerPlayerRepository extends \Doctrine\ORM\EntityRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new Mapping\ClassMetadata(SnookerPlayer::class));
    }

    public function insert($player)
    {
        $this->_em->persist($player);
        $this->_em->flush();

        return true;
    }

    public function getNames()
    {
        return $this->_em->createQueryBuilder()
            ->select('p.name')
            ->from('MyFantasyPlaceBundle:SnookerPlayer', 'p')
            ->getQuery()
            ->execute();
    }

    public function remove($player)
    {
        $this->_em->remove($player);
        $this->_em->flush();
    }
}
