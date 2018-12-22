<?php
/**
 * Created by PhpStorm.
 * UserService: valchevgd
 * Date: 12/21/2018
 * Time: 12:48 PM
 */

namespace MyFantasyPlaceBundle\Service\User;


use MyFantasyPlaceBundle\Repository\UserRepository;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserService implements UserServiceInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    private $passwordEncoder;


    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserRepository $userRepository,
                                UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }


    public function register(\MyFantasyPlaceBundle\Entity\User $user)
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

        $this->userRepository->createUser($user);

    }

    public function getSnookerRank()
    {
        $rank = $this->userRepository->findBy([],['snookerTotalPoints' => 'desc'], 5);

        return $rank;
    }

    public function getDartsRank()
    {
        $rank = $this->userRepository->findBy([],['dartsTotalPoints' => 'desc'], 5);

        return $rank;
    }
}