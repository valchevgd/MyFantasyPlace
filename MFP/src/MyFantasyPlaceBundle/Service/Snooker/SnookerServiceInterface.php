<?php
/**
 * Created by PhpStorm.
 * User: valchevgd
 * Date: 12/23/2018
 * Time: 7:43 PM
 */

namespace MyFantasyPlaceBundle\Service\Snooker;


use MyFantasyPlaceBundle\Entity\SnookerPlayer;

interface SnookerServiceInterface
{
    public function addPlayer(SnookerPlayer $player);

    public function getAllNames();

    public function removePlayers($players);
}