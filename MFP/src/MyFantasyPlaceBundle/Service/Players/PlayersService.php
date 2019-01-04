<?php

namespace MyFantasyPlaceBundle\Service\Players;


use Exception;
use MyFantasyPlaceBundle\DTO\DartsPlayerToUpdateDTO;
use MyFantasyPlaceBundle\DTO\SnookerPlayerToUpdateDTO;
use MyFantasyPlaceBundle\Entity\DartsPlayer;
use MyFantasyPlaceBundle\Entity\SnookerPlayer;
use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Repository\DartsPlayerRepository;
use MyFantasyPlaceBundle\Repository\SnookerPlayerRepository;
use MyFantasyPlaceBundle\Repository\UserDartsPlayerRepository;
use MyFantasyPlaceBundle\Repository\UserRepository;
use MyFantasyPlaceBundle\Repository\UserSnookerPlayerRepository;
use MyFantasyPlaceBundle\Service\User\UserServiceInterface;

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
     * @var UserDartsPlayerRepository
     */
    private $userDartsPlayerRepository;

    /**
     * @var UserSnookerPlayerRepository
     */
    private $userSnookerPlayerRepository;

    /**
     * @var UserServiceInterface
     */
    private $userRepository;


    /**
     * PlayersService constructor.
     * @param DartsPlayerRepository $dartsPlayerRepository
     * @param SnookerPlayerRepository $snookerPlayerRepository
     * @param UserDartsPlayerRepository $userDartsPlayerRepository
     * @param UserSnookerPlayerRepository $userSnookerPlayerRepository
     * @param UserRepository $userRepository
     */
    public function __construct(DartsPlayerRepository $dartsPlayerRepository,
                                SnookerPlayerRepository $snookerPlayerRepository,
                                UserDartsPlayerRepository $userDartsPlayerRepository,
                                UserSnookerPlayerRepository $userSnookerPlayerRepository,
                                UserRepository $userRepository)
    {
        $this->dartsPlayerRepository = $dartsPlayerRepository;
        $this->snookerPlayerRepository = $snookerPlayerRepository;
        $this->userDartsPlayerRepository = $userDartsPlayerRepository;
        $this->userSnookerPlayerRepository = $userSnookerPlayerRepository;
        $this->userRepository = $userRepository;
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

        $this->$repository->restartPlayersForSeason();

        $typeOfPointsToReset = 'u.'.$type.'SeasonPoints';
        $this->userRepository->restartUsersForSeason($typeOfPointsToReset);
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

        $users = $this->userDartsPlayerRepository->findUsers($dartsPlayer->getId());

        foreach ($users as $user){
            /** @var User $userToUpdate */
            $userToUpdate = $this->userRepository->findOneBy(['id' => $user['id']]);
            $userToUpdate->setDartsTournamentPoints($userToUpdate->getDartsTournamentPoints() + ($fantasyPoints * $user['level']));
            $userToUpdate->setDartsSeasonPoints($userToUpdate->getDartsSeasonPoints() + ($fantasyPoints * $user['level']));
            $userToUpdate->setFantasyTokens($userToUpdate->getFantasyTokens() + ($fantasyPoints * $user['level']));

            $this->userRepository->updateUser($userToUpdate);

        }

        $dartsPlayer->setTournamentFantasyPoints($dartsPlayer->getTournamentFantasyPoints() + $fantasyPoints);
        $dartsPlayer->setSeasonFantasyPoints($dartsPlayer->getSeasonFantasyPoints() + $fantasyPoints);

        $dartsPlayer->setTournamentOverHundred($dartsPlayer->getTournamentOverHundred() + $formData->getOverHundred());
        $dartsPlayer->setTournamentOverOneHundredAndForty($dartsPlayer->getTournamentOverOneHundredAndForty() + $formData->getOverOneHundredAndForty());
        $dartsPlayer->setTournamentMaximums($dartsPlayer->getTournamentMaximums() + $formData->getMaximums());

        $dartsPlayer->setSeasonOverHundred($dartsPlayer->getSeasonOverHundred() + $formData->getOverHundred());
        $dartsPlayer->setSeasonOverOneHundredAndForty($dartsPlayer->getSeasonOverOneHundredAndForty() + $formData->getOverOneHundredAndForty());
        $dartsPlayer->setSeasonMaximums($dartsPlayer->getSeasonMaximums() + $formData->getMaximums());

        $dartsPlayer->setStatus($formData->getStatus());

        return $this->dartsPlayerRepository->update($dartsPlayer);
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
            if ($century != 0 and ($centuries < 100 or $century > 148)){
                throw new Exception('Invalid value! Any series over one hundred should be between 100 and 148!');
            }
            $pointsFromCenturies += $century;
        }

        $fantasyPoints += $pointsFromCenturies / 10;

        $users = $this->userSnookerPlayerRepository->findUsers($snookerPlayer->getId());

        foreach ($users as $user){
            /** @var User $userToUpdate */
            $userToUpdate = $this->userRepository->findOneBy(['id' => $user['id']]);
            $userToUpdate->setSnookerTournamentPoints($userToUpdate->getSnookerTournamentPoints() + ($fantasyPoints * $user['level']));
            $userToUpdate->setSnookerSeasonPoints($userToUpdate->getSnookerSeasonPoints() + ($fantasyPoints * $user['level']));
            $userToUpdate->setFantasyTokens($userToUpdate->getFantasyTokens() + ($fantasyPoints * $user['level']));

            $this->userRepository->updateUser($userToUpdate);

        }

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

        $snookerPlayer->setStatus($formData->getStatus());

        return $this->snookerPlayerRepository->update($snookerPlayer);
    }

    public function getRank(string $type)
    {
        $repository = $type . 'PlayerRepository';

        $rank = $this->$repository->findBy([],['seasonFantasyPoints' => 'desc'], 5);

        return $rank;
    }

    public function getAllPlayers(string $type)
    {
        $repository = $type . 'PlayerRepository';
        $allPlayers = $this->$repository->findAll();

        return $allPlayers;
    }

    public function getPlayer(string $type, int $id)
    {
        $repository = $type . 'PlayerRepository';
        $player = $this->$repository->find($id);

        return $player;
    }

    public function getPlayerToUpdate($type)
    {
        $repository = $type . 'PlayerRepository';
        $player = $this->$repository->findOneBy(['newValue' => false]);

        return $player;
    }


    public function updateValue($player, string $type)
    {


        $repository = $type . 'PlayerRepository';

        $playerWithStatus = $this->$repository->findOneBy(['status' => 'running'],['value' => 'desc']);

        if ($playerWithStatus){
            throw new Exception('There are still players with status "running"! Please update players first!');
        }


        $player->setNewValue(true);
        return $player = $this->$repository->update($player);
    }
}