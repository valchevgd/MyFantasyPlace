<?php

namespace MyFantasyPlaceBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping;
use MyFantasyPlaceBundle\Entity\Tournament;

/**
 * TournamentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TournamentRepository extends \Doctrine\ORM\EntityRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new Mapping\ClassMetadata(Tournament::class));
    }

    /**
     * @param Tournament $tournament
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function insert(Tournament $tournament)
    {
        $this->_em->persist($tournament);
        $this->_em->flush();

        return true;
    }

    /**
     * @param Tournament $nextTournament
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Tournament $nextTournament)
    {
        $this->_em->persist($nextTournament);
        $this->_em->flush();

        return true;
    }

    /**
     * @param string $type
     * @return Tournament
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findCurrentOrUpcomingTournament(string $type)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->select('t')
            ->from('MyFantasyPlaceBundle:Tournament', 't')
            ->where('t.status = :running or t.status = :upcoming')
            ->andWhere('t.type = :type')
            ->setParameter('running', 'running')
            ->setParameter('upcoming', 'upcoming')
            ->setParameter('type', $type)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $qb->getQuery()->getOneOrNullResult();
    }
}
