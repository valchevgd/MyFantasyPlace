<?php
/**
 * Created by PhpStorm.
 * User: valchevgd
 * Date: 12/23/2018
 * Time: 7:43 PM
 */

namespace MyFantasyPlaceBundle\Service\Snooker;


use MyFantasyPlaceBundle\DTO\SnookerPlayerToUpdateDTO;
use MyFantasyPlaceBundle\Entity\SnookerPlayer;

interface SnookerServiceInterface
{
    public function addPlayer(SnookerPlayer $player);


    public function removePlayers($players);

    public function getList();

    public function updatePlayer(SnookerPlayerToUpdateDTO $formData);
}