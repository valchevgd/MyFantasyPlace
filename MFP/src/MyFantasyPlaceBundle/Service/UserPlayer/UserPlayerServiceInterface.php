<?php

namespace MyFantasyPlaceBundle\Service\UserPlayer;


use MyFantasyPlaceBundle\Entity\User;

interface UserPlayerServiceInterface
{
        public function makeTransfer($transfer, string $type, User $user, float $playerValue);

        public function findUsersPlayers(array $array);

        public function getPlayersToView(int $id, string $type);

        public function getPlayerToView(int $userId, string $type, int $playerId);

        public function upgradePlayer(User $user, int $playerId, string $type,float $tokens = null);

        public function remove(User $user,string $type,int $playerId, float $playerValue);
}