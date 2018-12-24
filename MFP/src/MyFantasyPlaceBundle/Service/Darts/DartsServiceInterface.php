<?php
/**
 * Created by PhpStorm.
 * User: valchevgd
 * Date: 12/24/2018
 * Time: 9:17 AM
 */

namespace MyFantasyPlaceBundle\Service\Darts;


use MyFantasyPlaceBundle\Entity\DartsPlayer;

interface DartsServiceInterface
{
    public function addPlayer(DartsPlayer $player);
}