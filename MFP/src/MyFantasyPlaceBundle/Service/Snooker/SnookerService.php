<?php
/**
 * Created by PhpStorm.
 * User: valchevgd
 * Date: 12/23/2018
 * Time: 7:46 PM
 */

namespace MyFantasyPlaceBundle\Service\Snooker;


use MyFantasyPlaceBundle\DTO\SnookerPlayerToUpdateDTO;
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

    public function removePlayers($players)
    {
        foreach ($players as $player) {

            $this->snookerPlayerRepository->remove($player);

        }
    }

    public function getList()
    {
        return $this->snookerPlayerRepository->findAll();
    }

    public function updatePlayer(SnookerPlayerToUpdateDTO $formData)
    {
        /** @var SnookerPlayer $snookerPlayer */
        $snookerPlayer = $this->snookerPlayerRepository->find($formData->getId());

        $fantasyPoints = $formData->getPointsScored() / 10;
        $fantasyPoints += $formData->getOverFifty() * 5;
        $fantasyPoints += $formData->getOverSixty() * 6;
        $fantasyPoints += $formData->getOverSeventy() * 7;
        $fantasyPoints += $formData->getOverEighty() * 8;
        $fantasyPoints += $formData->getOverNinety() * 9;

        $centuries = array_map('intval', explode(', ', $formData->getOverHundred()));

        $pointsFromCenturies = 0;

        foreach ($centuries as $century){
            $pointsFromCenturies += $century;
        }

        $fantasyPoints += $pointsFromCenturies / 10;

        $overSeventy = $formData->getOverSeventy() + $formData->getOverEighty() + $formData->getOverNinety();

        $snookerPlayer->setTournamentOverSeventy($snookerPlayer->getTournamentOverSeventy() + $overSeventy);
        $snookerPlayer->setSeasonOverSeventy($snookerPlayer->getSeasonOverSeventy() + $overSeventy);

        $overHundred = count(explode(', ', $formData->getOverHundred()));

        $snookerPlayer->setTournamentCenturies($snookerPlayer->getTournamentCenturies() + $overHundred);
        $snookerPlayer->setSeasonCenturies($snookerPlayer->getSeasonCenturies() + $overHundred);

        $snookerPlayer->setTournamentFantasyPoints($snookerPlayer->getTournamentFantasyPoints() + $fantasyPoints);
        $snookerPlayer->setSeasonPoints($snookerPlayer->getSeasonFantasyPoints() + $fantasyPoints);

        $this->snookerPlayerRepository->update($snookerPlayer);
    }
}