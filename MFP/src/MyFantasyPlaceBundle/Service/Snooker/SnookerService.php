<?php
/**
 * Created by PhpStorm.
 * User: valchevgd
 * Date: 12/23/2018
 * Time: 7:46 PM
 */

namespace MyFantasyPlaceBundle\Service\Snooker;


use MyFantasyPlaceBundle\Entity\SnookerPlayer;
use MyFantasyPlaceBundle\Repository\SnookerPlayerRepository;

class SnookerService implements SnookerServiceInterface
{

    /**
     * @var SnookerPlayerRepository
     */
    private $snookerPlayerRepository;

    /**
     * SnookerService constructor.
     * @param SnookerPlayerRepository $snookerPlayerRepository
     */
    public function __construct(SnookerPlayerRepository $snookerPlayerRepository)
    {
        $this->snookerPlayerRepository = $snookerPlayerRepository;
    }


    public function addPlayer(SnookerPlayer $player)
    {
        return $this->snookerPlayerRepository->insert($player);
    }

    public function getAllNames()
    {
        return $this->snookerPlayerRepository->getNames();
    }

    public function removePlayers($players)
    {
        foreach ($players as $player) {

            $this->snookerPlayerRepository->remove($player);

        }
    }
}