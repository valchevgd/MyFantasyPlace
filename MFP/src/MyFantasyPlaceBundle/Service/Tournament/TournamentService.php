<?php

namespace MyFantasyPlaceBundle\Service\Tournament;


use MyFantasyPlaceBundle\Entity\Tournament;
use MyFantasyPlaceBundle\Repository\TournamentRepository;

class TournamentService implements TournamentServiceInterface
{
    /** @var TournamentRepository */
    private $tournamentRepository;

    /**
     * TournamentService constructor.
     * @param TournamentRepository $tournamentRepository
     */
    public function __construct(TournamentRepository $tournamentRepository)
    {
        $this->tournamentRepository = $tournamentRepository;
    }


    public function addTournament(Tournament $tournament)
    {
        return $this->tournamentRepository->insert($tournament);
    }


    public function getNext(string $type)
    {
        return $this->tournamentRepository->findBy(['type' => $type, 'status' => 'upcoming'], ['startingDate' => 'asc'], 1);
    }
}