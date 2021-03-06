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

    /**
     * @param DartsPlayer $player
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function insert(DartsPlayer $player)
    {
        $this->_em->persist($player);
        $this->_em->flush();

        return true;
    }

    /**
     * @param DartsPlayer $player
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(DartsPlayer $player)
    {
        $this->_em->remove($player);
        $this->_em->flush();

        return true;
    }

    /**
     * @param DartsPlayer $player
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(DartsPlayer $player)
    {
        $this->_em->merge($player);
        $this->_em->flush();

        return true;
    }

    /**
     * @return bool
     */
    public function restartPlayersForTournament()
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->update('MyFantasyPlaceBundle:DartsPlayer', 'dp')
            ->set('dp.tournamentOverHundred', '0')
            ->set('dp.tournamentOverOneHundredAndForty', '0')
            ->set('dp.tournamentMaximums', '0')
            ->set('dp.tournamentFantasyPoints', '0')
            ->set('dp.status', 'null')
            ->set('dp.newValue', 'false')
            ->getQuery();

        $qb->getQuery()->execute();

        return true;
    }

    /**
     * @return bool
     */
    public function restartPlayersForSeason()
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->update('MyFantasyPlaceBundle:DartsPlayer', 'dp')
            ->set('dp.seasonOverHundred', '0')
            ->set('dp.seasonOverOneHundredAndForty', '0')
            ->set('dp.seasonMaximums', '0')
            ->set('dp.seasonFantasyPoints', '0')

            ->getQuery();

        $qb->getQuery()->execute();

        return true;
    }

}
