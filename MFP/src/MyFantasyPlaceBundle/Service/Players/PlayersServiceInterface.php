<?php

namespace MyFantasyPlaceBundle\Service\Players;


use MyFantasyPlaceBundle\DTO\DartsPlayerToUpdateDTO;
use MyFantasyPlaceBundle\DTO\SnookerPlayerToUpdateDTO;
use MyFantasyPlaceBundle\Entity\DartsPlayer;

interface PlayersServiceInterface
{
    public function addPlayer($player, string $type);

    public function removePlayers($players, string $type);

    public function updateDartsPlayer(DartsPlayerToUpdateDTO $formData);

    public function updateSnookerPlayer(SnookerPlayerToUpdateDTO $formData);

    public function getRank(string $type);
}