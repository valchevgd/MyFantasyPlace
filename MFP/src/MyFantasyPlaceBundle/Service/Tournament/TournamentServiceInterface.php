<?php

namespace MyFantasyPlaceBundle\Service\Tournament;


use MyFantasyPlaceBundle\Entity\SnookerPlayer;
use MyFantasyPlaceBundle\Entity\Tournament;

interface TournamentServiceInterface
{
    public function addTournament(Tournament $tournament);

    public function getNext(string $type);

    public function startTournament(Tournament $nextTournament, $players, string $type);

    public function getCurrentTournament(string $type);

    public function finishTournament(Tournament $tournament, string $type);

}