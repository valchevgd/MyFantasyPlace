<?php
/**
 * Created by PhpStorm.
 * UserService: valchevgd
 * Date: 12/21/2018
 * Time: 12:46 PM
 */

namespace MyFantasyPlaceBundle\Service\User;


use MyFantasyPlaceBundle\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UserServiceInterface
{
    public function register(User $user);

    public function getSnookerRank();

    public function getDartsRank();

    public function getViewUser(int $id);

    public function update(User $user);

    public function prepareUser(User $currentUser,string $username,string $email, UploadedFile $file = null);
}