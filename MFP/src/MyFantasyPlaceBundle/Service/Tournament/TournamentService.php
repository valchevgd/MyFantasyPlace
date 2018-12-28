<?php

namespace MyFantasyPlaceBundle\Service\Tournament;


use MyFantasyPlaceBundle\Entity\DartsPlayer;
use MyFantasyPlaceBundle\Entity\SnookerPlayer;
use MyFantasyPlaceBundle\Entity\Tournament;
use MyFantasyPlaceBundle\Repository\DartsPlayerRepository;
use MyFantasyPlaceBundle\Repository\SnookerPlayerRepository;
use MyFantasyPlaceBundle\Repository\TournamentRepository;
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
     * TournamentService constructor.
     * @param TournamentRepository $tournamentRepository
     * @param DartsPlayerRepository $dartsPlayerRepository
     * @param SnookerPlayerRepository $snookerPlayerRepository
     */
    public function __construct(TournamentRepository $tournamentRepository,
                                DartsPlayerRepository $dartsPlayerRepository,
                                SnookerPlayerRepository $snookerPlayerRepository)
    {
        $this->tournamentRepository = $tournamentRepository;
        $this->dartsPlayerRepository = $dartsPlayerRepository;
        $this->snookerPlayerRepository = $snookerPlayerRepository;
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

        if ($runningTournament){
            throw new Exception($runningTournament->getName());
        }

        $nextTournament->setStatus('running');
        $this->tournamentRepository->update($nextTournament);

        $repository = $type . 'PlayerRepository';

        foreach ($players as $player){
            $player->setStatus('running');
            $this->$repository->updateStatus($player);
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

        if ($playerWithStatus){
            throw new Exception('There are still players with status "running"! Please update players first!');
        }

        $tournament->setStatus('finished');

        $this->tournamentRepository->update($tournament);

        $players = $this->$repository->findAll();

        $playerType = $type.'Type';

        foreach ($players as $player) {

            $player->setStatus(null);
            $player = $this->$playerType($player);
            $this->$repository->updateStatus($player);
        }

        return true;
    }

    private function snookerType(SnookerPlayer $player)
    {
        $player->setTournamentFantasyPoints(0);
        $player->setTournamentOverSeventy(0);
        $player->setTournamentCenturies(0);

        return $player;
    }

    private function dartsType(DartsPlayer $player)
    {
        $player->setTournamentFantasyPoints(0);
        $player->setTournamentOverHundred(0);
        $player->setTournamentOverOneHundredAndForty(0);
        $player->setTournamentMaximums(0);
        $player->setTournamentCheckoutPercentage(0);
        $player->setTournamentAverageThreeDarts(0);
        $player->setTournamentGamesPlayed(0);

        return $player;
    }
}