<?php

namespace MyFantasyPlaceBundle\Service\UserPlayer;


use MyFantasyPlaceBundle\Entity\User;

interface UserPlayerServiceInterface
{
        public function makeTransfer($transfer, string $type, User $user, float $playerValue);

        public function findUsersPlayers(array $array);
}