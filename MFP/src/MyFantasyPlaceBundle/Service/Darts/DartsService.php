<?php
/**
 * Created by PhpStorm.
 * User: valchevgd
 * Date: 12/24/2018
 * Time: 9:18 AM
 */

namespace MyFantasyPlaceBundle\Service\Darts;


use MyFantasyPlaceBundle\Entity\DartsPlayer;
use MyFantasyPlaceBundle\Repository\DartsPlayerRepository;

class DartsService implements DartsServiceInterface
{
    /**
     * @var DartsPlayerRepository
     */
    private $dartsPlayerRepository;

    /**
     * DartsService constructor.
     * @param DartsPlayerRepository $dartsPlayerRepository
     */
    public function __construct(DartsPlayerRepository $dartsPlayerRepository)
    {
        $this->dartsPlayerRepository = $dartsPlayerRepository;
    }


    public function addPlayer(DartsPlayer $player)
    {
        return $this->dartsPlayerRepository->insert($player);
    }
}