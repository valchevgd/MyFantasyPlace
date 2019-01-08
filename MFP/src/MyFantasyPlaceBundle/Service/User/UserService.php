<?php

namespace MyFantasyPlaceBundle\Service\User;


use MyFantasyPlaceBundle\DTO\ChangePasswordDTO;
use MyFantasyPlaceBundle\Entity\Role;
use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Repository\RoleRepository;
use MyFantasyPlaceBundle\Repository\UserRepository;
use MyFantasyPlaceBundle\Service\Role\RoleServiceInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    private $passwordEncoder;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RoleServiceInterface
     */
    private $roleService;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param ContainerInterface $container
     * @param RoleServiceInterface $roleService
     */
    public function __construct(UserRepository $userRepository,
                                UserPasswordEncoderInterface $passwordEncoder,
                                ContainerInterface $container,
                                RoleServiceInterface $roleService)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->container = $container;
        $this->roleService = $roleService;
    }


    public function register(User $user)
    {
        $userByUsername = $this->userRepository->findBy(['username' => $user->getUsername()]);

        if ($userByUsername) {
            throw new Exception('Username is already taken!');
        }

        $userByEmail = $this->userRepository->findBy(['email' => $user->getEmail()]);

        if ($userByEmail) {
            throw new Exception('Email is already taken!');
        }

        $password = $this->passwordEncoder->encodePassword($user, $user->getPassword());

        $user->setPassword($password);

        /** @var Role $role */
        $role = $this->roleService->getRole('ROLE_USER');
        $user->addRole($role);

        $this->userRepository->createUser($user);

    }


    public function getRank(string $type, int $limit = null)
    {
        $typeRank = $type.'SeasonPoints';

        $rank = $this->userRepository->findBy([],[$typeRank => 'desc'], $limit);

        return $rank;
    }

    public function getViewUser(int $id)
    {
        return $this->userRepository->find($id);
    }

    public function update(User $user)
    {
        return $this->userRepository->updateUser($user);
    }

    public function prepareUser(User $currentUser, string $username, string $email, UploadedFile $file = null)
    {
        if ($file){
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            try {
                $file->move($this->container->getParameter('user_directory'),
                    $fileName);
            } catch (FileException $ex) {

            }
            $currentUser->setImage($fileName);
        }

        $currentUser->setUsername($username);
        $currentUser->setEmail($email);

        return $currentUser;
    }

    public function changePassword(User $user, ChangePasswordDTO $newPassword)
    {
        $password = $this->passwordEncoder->encodePassword($user, $newPassword->getNewPassword());

        $user->setPassword($password);

        return $this->userRepository->updateUser($user);
    }

    public function deleteUser(User $user, string $password, TokenStorageInterface $tokenStorage, SessionInterface $session)
    {
        if($this->passwordEncoder->isPasswordValid($user, $password)){
            if ($this->userRepository->removeUser($user)){
                $tokenStorage->setToken(null);
                $session->invalidate();
            }
        }else{
            throw new Exception('Wrong password!');
        }

        return true;
    }

    public function restartUsersForSeason($typeOfPointsToReset)
    {
        return $this->userRepository->restartUsersForSeason($typeOfPointsToReset);
    }

    public function getUser(int $id)
    {
        return $this->userRepository->findOneBy(['id' => $id]);
    }

    public function restartUsersForTournament($type)
    {
        $typeOfPointsToReset = 'u.'.$type.'TournamentPoints';
        $typeOfTransfer = 'u.'.$type.'Transfer';

        return $this->userRepository->restartUsersForTournament($typeOfPointsToReset, $typeOfTransfer);
    }
}