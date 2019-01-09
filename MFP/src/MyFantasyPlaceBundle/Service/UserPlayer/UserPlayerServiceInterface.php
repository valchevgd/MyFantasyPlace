<?php

namespace MyFantasyPlaceBundle\Service\UserPlayer;


use Doctrine\Common\Collections\ArrayCollection;
use MyFantasyPlaceBundle\DTO\PlayerToViewDTO;
use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Entity\UserDartsPlayer;
use MyFantasyPlaceBundle\Entity\UserSnookerPlayer;

interface UserPlayerServiceInterface
{

    /**
     * @param UserSnookerPlayer|UserDartsPlayer $transfer
     * @param string $type
     * @param User $user
     * @param float $playerValue
     * @return boolean
     */
    public function makeTransfer($transfer, string $type, User $user, float $playerValue);

    /**
     * @param array $array
     * @return array
     */
    public function findUsersPlayers(array $array);

    /**
     * @param int $id
     * @param string $type
     * @return PlayerToViewDTO[]
     */
    public function getPlayersToView(int $id, string $type);

    /**
     * @param int $userId
     * @param string $type
     * @param int $playerId
     * @return PlayerToViewDTO
     */
    public function getPlayerToView(int $userId, string $type, int $playerId);

    /**
     * @param User $user
     * @param int $playerId
     * @param string $type
     * @param float|null $tokens
     * @return boolean
     */
    public function upgradePlayer(User $user, int $playerId, string $type, float $tokens = null);

    /**
     * @param User $user
     * @param string $type
     * @param int $playerId
     * @param float $playerValue
     * @return boolean
     */
    public function remove(User $user, string $type, int $playerId, float $playerValue);

    /**
     * @param int $id
     * @param string $type
     * @return array
     */
    public function getUsers(int $id, string $type);

}