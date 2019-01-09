<?php

namespace MyFantasyPlaceBundle\Service\Tournament;


use MyFantasyPlaceBundle\DTO\PlayersDTO;
use MyFantasyPlaceBundle\Entity\SnookerPlayer;
use MyFantasyPlaceBundle\Entity\Tournament;

interface TournamentServiceInterface
{
    /**
     * @param Tournament $tournament
     * @return boolean
     */
    public function addTournament(Tournament $tournament);

    /**
     * @param string $type
     * @return Tournament
     */
    public function getNext(string $type);

    /**
     * @param Tournament $nextTournament
     * @param PlayersDTO $players
     * @param string $type
     * @return boolean
     */
    public function startTournament(Tournament $nextTournament, $players, string $type);

    /**
     * @param string $type
     * @return Tournament
     */
    public function getCurrentTournament(string $type);

    /**
     * @param Tournament $tournament
     * @param string $type
     * @return boolean
     */
    public function finishTournament(Tournament $tournament, string $type);

}