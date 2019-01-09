<?php

namespace MyFantasyPlaceBundle\Service\Tournament;

use MyFantasyPlaceBundle\Entity\Tournament;
use MyFantasyPlaceBundle\Repository\DartsPlayerRepository;
use MyFantasyPlaceBundle\Repository\SnookerPlayerRepository;
use MyFantasyPlaceBundle\Repository\TournamentRepository;
use MyFantasyPlaceBundle\Repository\UserRepository;
use MyFantasyPlaceBundle\Service\Players\PlayersServiceInterface;
use MyFantasyPlaceBundle\Service\User\UserServiceInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class TournamentService implements TournamentServiceInterface
{
    /** @var TournamentRepository */
    private $tournamentRepository;

    /**
     * @var PlayersServiceInterface
     */
    private $playerService;

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * TournamentService constructor.
     * @param TournamentRepository $tournamentRepository
     * @param PlayersServiceInterface $playerService
     * @param UserServiceInterface $userService
     */
    public function __construct(TournamentRepository $tournamentRepository,
                                PlayersServiceInterface $playerService,
                                UserServiceInterface $userService)
    {
        $this->tournamentRepository = $tournamentRepository;
        $this->playerService = $playerService;
        $this->userService = $userService;
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

        $playersToArray = $players->getPlayers()->toArray();

        foreach ($playersToArray as $player) {
            if(!$this->playerService->updateStatus($player, $type)){
                break;
            }
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

        $playerWithStatus = $this->playerService->getOneBy(['status' => 'running'], $type);
        $playerWithoutNewValue = $this->playerService->getOneBy(['newValue' => false], $type);

        if ($playerWithStatus or $playerWithoutNewValue) {
            throw new Exception('\'There are still players with status "running" OR players with no updated value! Please update players first!');
        }

        $this->userService->restartUsersForTournament($type);

        $this->playerService->restartPlayersForTournament($type);

        $tournament->setStatus('finished');

        return $this->tournamentRepository->update($tournament);

    }

}