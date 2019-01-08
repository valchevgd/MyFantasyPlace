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

    public function getAllPlayers(string $type, string $order);

    public function getPlayer(string $type, int $id);

    public function getPlayerToUpdate($type);

    public function updateValue($player, string $type);

    public function updateStatus($player, string $type);

    public function getOneBy(array $array, string $type);

    public function restartPlayersForTournament(string $type);
}