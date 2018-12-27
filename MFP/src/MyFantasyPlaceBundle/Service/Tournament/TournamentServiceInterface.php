<?php

namespace MyFantasyPlaceBundle\Service\Tournament;


use MyFantasyPlaceBundle\Entity\Tournament;

interface TournamentServiceInterface
{
    public function addTournament(Tournament $tournament);

    public function getNext(string $type);
}