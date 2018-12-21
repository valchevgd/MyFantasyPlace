<?php
/**
 * Created by PhpStorm.
 * UserService: valchevgd
 * Date: 12/21/2018
 * Time: 12:46 PM
 */

namespace MyFantasyPlaceBundle\Service\User;


use MyFantasyPlaceBundle\Entity\User;

interface UserServiceInterface
{
    public function register(User $user, string $confirmPassword);
}