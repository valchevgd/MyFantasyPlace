<?php

namespace MyFantasyPlaceBundle\Service\Players;


use MyFantasyPlaceBundle\DTO\DartsPlayerToUpdateDTO;
use MyFantasyPlaceBundle\DTO\SnookerPlayerToUpdateDTO;
use MyFantasyPlaceBundle\Entity\DartsPlayer;
use MyFantasyPlaceBundle\Entity\SnookerPlayer;
use MyFantasyPlaceBundle\Repository\DartsPlayerRepository;
use MyFantasyPlaceBundle\Repository\SnookerPlayerRepository;

class PlayersService implements PlayersServiceInterface
{
    /**
     * @var DartsPlayerRepository
     */
    private $dartsPlayerRepository;

    /**
     * @var SnookerPlayerRepository
     */
    private $snookerPlayerRepository;

    /**
     * PlayersService constructor.
     * @param DartsPlayerRepository $dartsPlayerRepository
     * @param SnookerPlayerRepository $snookerPlayerRepository
     */
    public function __construct(DartsPlayerRepository $dartsPlayerRepository,
                                SnookerPlayerRepository $snookerPlayerRepository)
    {
        $this->dartsPlayerRepository = $dartsPlayerRepository;
        $this->snookerPlayerRepository = $snookerPlayerRepository;
    }


    public function addPlayer($player, string $type)
    {
        $repository = $type . 'PlayerRepository';
        return $this->$repository->insert($player);
    }

    public function removePlayers($players, string $type)
    {
        $repository = $type . 'PlayerRepository';

        foreach ($players as $player) {

            $this->$repository->remove($player);

        }
    }

    public function updateDartsPlayer(DartsPlayerToUpdateDTO $formData)
    {

        $fantasyPoints = $formData->getOverHundred() * 0.6;
        $fantasyPoints += $formData->getOverOneHundredAndForty() * 1.4;
        $fantasyPoints += $formData->getMaximums() * 2.8;
        $fantasyPoints += $formData->getCheckoutPercentage() / 10;
        $fantasyPoints += $formData->getAverageThreeDarts() / 10;

        /** @var DartsPlayer $dartsPlayer */
        $dartsPlayer = $this->dartsPlayerRepository->find($formData->getId());

        $dartsPlayer->setTournamentFantasyPoints($dartsPlayer->getTournamentFantasyPoints() + $fantasyPoints);
        $dartsPlayer->setSeasonFantasyPoints($dartsPlayer->getSeasonFantasyPoints() + $fantasyPoints);

        $dartsPlayer->setTournamentOverHundred($dartsPlayer->getTournamentOverHundred() + $formData->getOverHundred());
        $dartsPlayer->setTournamentOverOneHundredAndForty($dartsPlayer->getTournamentOverOneHundredAndForty() + $formData->getOverOneHundredAndForty());
        $dartsPlayer->setTournamentMaximums($dartsPlayer->getTournamentMaximums() + $formData->getMaximums());
        $dartsPlayer->setTournamentCheckoutPercentage($dartsPlayer->getTournamentCheckoutPercentage() + $formData->getCheckoutPercentage());
        $dartsPlayer->setTournamentAverageThreeDarts($dartsPlayer->getTournamentAverageThreeDarts() + $formData->getAverageThreeDarts());
        $dartsPlayer->setTournamentGamesPlayed($dartsPlayer->getTournamentGamesPlayed() + 1);

        $dartsPlayer->setSeasonOverHundred($dartsPlayer->getSeasonOverHundred() + $formData->getOverHundred());
        $dartsPlayer->setSeasonOverOneHundredAndForty($dartsPlayer->getSeasonOverOneHundredAndForty() + $formData->getOverOneHundredAndForty());
        $dartsPlayer->setSeasonMaximums($dartsPlayer->getSeasonMaximums() + $formData->getMaximums());
        $dartsPlayer->setSeasonCheckoutPercentage($dartsPlayer->getSeasonCheckoutPercentage() + $formData->getCheckoutPercentage());
        $dartsPlayer->setSeasonAverageThreeDarts($dartsPlayer->getSeasonAverageThreeDarts() + $formData->getAverageThreeDarts());
        $dartsPlayer->setSeasonGamesPlayed($dartsPlayer->getSeasonGamesPlayed() + 1);

        $dartsPlayer->setValue($formData->getValue());
        $dartsPlayer->setStatus($formData->getStatus());

        $this->dartsPlayerRepository->update($dartsPlayer);
    }

    public function updateSnookerPlayer(SnookerPlayerToUpdateDTO $formData)
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

        foreach ($centuries as $century) {
            $pointsFromCenturies += $century;
        }

        $fantasyPoints += $pointsFromCenturies / 10;

        $overSeventy = $formData->getOverSeventy() + $formData->getOverEighty() + $formData->getOverNinety();

        $snookerPlayer->setTournamentOverSeventy($snookerPlayer->getTournamentOverSeventy() + $overSeventy);
        $snookerPlayer->setSeasonOverSeventy($snookerPlayer->getSeasonOverSeventy() + $overSeventy);

        if (intval($formData->getOverHundred()[0]) === 0) {
            $overHundred = 0;
        } else {
            $overHundred = count(explode(', ', $formData->getOverHundred()));
        }

        $snookerPlayer->setTournamentCenturies($snookerPlayer->getTournamentCenturies() + $overHundred);
        $snookerPlayer->setSeasonCenturies($snookerPlayer->getSeasonCenturies() + $overHundred);

        $snookerPlayer->setTournamentFantasyPoints($snookerPlayer->getTournamentFantasyPoints() + $fantasyPoints);
        $snookerPlayer->setSeasonPoints($snookerPlayer->getSeasonFantasyPoints() + $fantasyPoints);

        $snookerPlayer->setValue($formData->getValue());
        $snookerPlayer->setStatus($formData->getStatus());

        $this->snookerPlayerRepository->update($snookerPlayer);
    }
}