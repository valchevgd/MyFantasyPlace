<?php

namespace MyFantasyPlaceBundle\Service\Players;


use MyFantasyPlaceBundle\DTO\DartsPlayerToUpdateDTO;
use MyFantasyPlaceBundle\DTO\PlayersDTO;
use MyFantasyPlaceBundle\DTO\SnookerPlayerToUpdateDTO;
use MyFantasyPlaceBundle\Entity\DartsPlayer;
use MyFantasyPlaceBundle\Entity\SnookerPlayer;

interface PlayersServiceInterface
{
    /**
     * @param SnookerPlayer|DartsPlayer $player
     * @param string $type
     * @return boolean
     */
    public function addPlayer($player, string $type);

    /**
     * @param PlayersDTO $players
     * @param string $type
     * @return boolean
     */
    public function removePlayers($players, string $type);

    /**
     * @param DartsPlayerToUpdateDTO $formData
     * @return boolean
     */
    public function updateDartsPlayer(DartsPlayerToUpdateDTO $formData);

    /**
     * @param SnookerPlayerToUpdateDTO $formData
     * @return boolean
     */
    public function updateSnookerPlayer(SnookerPlayerToUpdateDTO $formData);

    /**
     * @param string $type
     * @return SnookerPlayer[]|DartsPlayer[]
     */
    public function getRank(string $type);

    /**
     * @param string $type
     * @param string $order
     * @return SnookerPlayer[]|DartsPlayer[]
     */
    public function getAllPlayers(string $type, string $order);

    /**
     * @param string $type
     * @param int $id
     * @return SnookerPlayer|DartsPlayer
     */
    public function getPlayer(string $type, int $id);

    /**
     * @param $type
     * @return SnookerPlayer|DartsPlayer
     */
    public function getPlayerToUpdate($type);

    /**
     * @param SnookerPlayer|DartsPlayer $player
     * @param string $type
     * @return boolean
     */
    public function updateValue($player, string $type);

    /**
     * @param SnookerPlayer|DartsPlayer $player
     * @param string $type
     * @return boolean
     */
    public function updateStatus($player, string $type);

    /**
     * @param array $array
     * @param string $type
     * @return SnookerPlayer|DartsPlayer
     */
    public function getOneBy(array $array, string $type);

    /**
     * @param string $type
     * @return boolean
     */
    public function restartPlayersForTournament(string $type);
}