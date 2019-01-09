<?php
/**
 * Created by PhpStorm.
 * UserService: valchevgd
 * Date: 12/21/2018
 * Time: 12:46 PM
 */

namespace MyFantasyPlaceBundle\Service\User;


use MyFantasyPlaceBundle\DTO\ChangePasswordDTO;
use MyFantasyPlaceBundle\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

interface UserServiceInterface
{
    /**
     * @param User $user
     * @return boolean
     */
    public function register(User $user);

    /**
     * @param string $type
     * @param string $period
     * @param int|null $limit
     * @return User[]
     */
    public function getRank(string $type, string $period,int $limit = null);

    /**
     * @param int $id
     * @return User
     */
    public function getViewUser(int $id);

    /**
     * @param User $user
     * @return boolean
     */
    public function update(User $user);

    /**
     * @param User $currentUser
     * @param string $username
     * @param string $email
     * @param UploadedFile|null $file
     * @return User
     */
    public function prepareUser(User $currentUser,string $username,string $email, UploadedFile $file = null);

    /**
     * @param User $user
     * @param ChangePasswordDTO $newPassword
     * @return boolean
     */
    public function changePassword(User $user,ChangePasswordDTO $newPassword);

    /**
     * @param User $user
     * @param string $password
     * @param TokenStorageInterface $tokenStorage
     * @param SessionInterface $session
     * @return boolean
     */
    public function deleteUser(User $user,string $password, TokenStorageInterface $tokenStorage, SessionInterface $session);

    /**
     * @param string $typeOfPointsToReset
     * @return boolean
     */
    public function restartUsersForSeason(string $typeOfPointsToReset);

    /**
     * @param int $id
     * @return User
     */
    public function getUser(int $id);

    /**
     * @param string $type
     * @return boolean
     */
    public function restartUsersForTournament(string $type);
}