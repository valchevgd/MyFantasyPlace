<?php
/**
 * Created by PhpStorm.
 * User: valchevgd
 * Date: 12/24/2018
 * Time: 9:18 AM
 */

namespace MyFantasyPlaceBundle\Service\Darts;


use MyFantasyPlaceBundle\DTO\DartsPlayerToUpdateDTO;
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

    public function removePlayers($players)
    {
        foreach ($players as $player) {

            $this->dartsPlayerRepository->remove($player);

        }
    }

    public function updatePlayer(DartsPlayerToUpdateDTO $formData)
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
}