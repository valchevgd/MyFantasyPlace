<?php
/**
 * Created by PhpStorm.
 * UserService: valchevgd
 * Date: 12/21/2018
 * Time: 12:48 PM
 */

namespace MyFantasyPlaceBundle\Service\User;


use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Repository\UserRepository;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


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
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param ContainerInterface|null $container
     */
    public function __construct(UserRepository $userRepository,
                                UserPasswordEncoderInterface $passwordEncoder,
                                ContainerInterface $container = null)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->container = $container;
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

        $this->userRepository->createUser($user);

    }

    public function getSnookerRank()
    {
        $rank = $this->userRepository->findBy(['isAdmin' => false],['snookerSeasonPoints' => 'desc'], 5);

        return $rank;
    }

    public function getDartsRank()
    {
        $rank = $this->userRepository->findBy(['isAdmin' => false],['dartsSeasonPoints' => 'desc'], 5);

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
}