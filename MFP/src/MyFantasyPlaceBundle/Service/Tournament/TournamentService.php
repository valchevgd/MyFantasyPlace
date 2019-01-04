<?php

namespace MyFantasyPlaceBundle\Service\Tournament;

use MyFantasyPlaceBundle\Entity\Tournament;
use MyFantasyPlaceBundle\Repository\DartsPlayerRepository;
use MyFantasyPlaceBundle\Repository\SnookerPlayerRepository;
use MyFantasyPlaceBundle\Repository\TournamentRepository;
use MyFantasyPlaceBundle\Repository\UserRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

class TournamentService implements TournamentServiceInterface
{
    /** @var TournamentRepository */
    private $tournamentRepository;

    /**
     * @var DartsPlayerRepository
     */
    private $dartsPlayerRepository;

    /**
     * @var SnookerPlayerRepository
     */
    private $snookerPlayerRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * TournamentService constructor.
     * @param TournamentRepository $tournamentRepository
     * @param DartsPlayerRepository $dartsPlayerRepository
     * @param SnookerPlayerRepository $snookerPlayerRepository
     * @param UserRepository $userRepository
     */
    public function __construct(TournamentRepository $tournamentRepository,
                                DartsPlayerRepository $dartsPlayerRepository,
                                SnookerPlayerRepository $snookerPlayerRepository,
                                UserRepository $userRepository)
    {
        $this->tournamentRepository = $tournamentRepository;
        $this->dartsPlayerRepository = $dartsPlayerRepository;
        $this->snookerPlayerRepository = $snookerPlayerRepository;
        $this->userRepository = $userRepository;
    }


    public function addTournament(Tournament $tournament)
    {
        return $this->tournamentRepository->insert($tournament);
    }


    public function getNext(string $type)
    {
        return $this->tournamentRepository->findOneBy(['type' => $type, 'status' => 'upcoming'], ['startingDate' => 'asc']);
    }

    public function startTournament(Tournament $nextTournament, $players, string $type)
    {
        /** @var Tournament $runningTournament */
        $runningTournament = $this->tournamentRepository->findOneBy(['status' => 'running', 'type' => $type]);

        if ($runningTournament) {
            throw new Exception($runningTournament->getName());
        }

        $nextTournament->setStatus('running');
        $this->tournamentRepository->update($nextTournament);

        $repository = $type . 'PlayerRepository';

        foreach ($players as $player) {
            $player->setStatus('running');
            $this->$repository->update($player);
        }

        return true;
    }

    public function getCurrentTournament(string $type)
    {
        return $this->tournamentRepository->findOneBy(['status' => 'running', 'type' => $type]);
    }

    public function finishTournament(Tournament $tournament, string $type)
    {
        $repository = $type . 'PlayerRepository';

        $playerWithStatus = $this->$repository->findOneBy(['status' => 'running']);
        $playerWithoutNewValue = $this->$repository->findOneBy(['newValue' => false]);

        if ($playerWithStatus or $playerWithoutNewValue) {
            throw new Exception('\'There are still players with status "running" OR players with no updated value! Please update players first!');
        }

        $typeOfPointsToReset = 'u.'.$type.'TournamentPoints';
        $this->userRepository->restartUsersForTournament($typeOfPointsToReset);

        $this->$repository->restartPlayersForTournament();

        $tournament->setStatus('finished');

        $this->tournamentRepository->update($tournament);
        return true;
    }

}