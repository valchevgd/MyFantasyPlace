<?php

namespace MyFantasyPlaceBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping;
use MyFantasyPlaceBundle\Entity\DartsPlayer;

/**
 * DartsPlayerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DartsPlayerRepository extends \Doctrine\ORM\EntityRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new Mapping\ClassMetadata(DartsPlayer::class));
    }

    public function insert(DartsPlayer $player)
    {
        $this->_em->persist($player);
        $this->_em->flush();

        return true;
    }

    public function remove($player)
    {
        $this->_em->remove($player);
        $this->_em->flush();
    }

    public function update(DartsPlayer $player)
    {
        $this->_em->merge($player);
        $this->_em->flush();

        return true;
    }

    public function restartPlayersForTournament()
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->update('MyFantasyPlaceBundle:DartsPlayer', 'dp')
            ->set('dp.tournamentOverOneHundred', 0)
            ->set('dp.tournamentOverOneHundredAndForty', 0)
            ->set('dp.tournamentMaximums', 0)
            ->set('dp.tournamentFantasyPoints', 0)
            ->set('dp.status', null)
            ->set('dp.newStatus', false)
            ->getQuery();
    }



}
