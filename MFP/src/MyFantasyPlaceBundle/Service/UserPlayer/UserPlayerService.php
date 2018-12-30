<?php


namespace MyFantasyPlaceBundle\Service\UserPlayer;


use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Repository\UserDartsPlayerRepository;
use MyFantasyPlaceBundle\Repository\UserRepository;
use MyFantasyPlaceBundle\Repository\UserSnookerPlayerRepository;

class UserPlayerService implements UserPlayerServiceInterface
{

    /**
     * @var UserDartsPlayerRepository
     */
    private $userDartsPlayerRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserSnookerPlayerRepository
     */
    private $userSnookerPlayerRepository;

    /**
     * UserPlayerService constructor.
     * @param UserDartsPlayerRepository $userDartsPlayerRepository
     * @param UserRepository $userRepository
     * @param UserSnookerPlayerRepository $userSnookerPlayerRepository
     */
    public function __construct(UserDartsPlayerRepository $userDartsPlayerRepository,
                                UserRepository $userRepository,
                                UserSnookerPlayerRepository $userSnookerPlayerRepository)
    {
        $this->userDartsPlayerRepository = $userDartsPlayerRepository;
        $this->userRepository = $userRepository;
        $this->userSnookerPlayerRepository = $userSnookerPlayerRepository;
    }

    public function makeTransfer($transfer, string $type, User $user, float $playerValue)
    {

       $repository = 'user'.ucfirst($type).'PlayerRepository';

        if($this->$repository->insert($transfer)){
            $getter = 'get'.ucfirst($type).'TeamValue';
            $setter = 'set'.ucfirst($type).'TeamValue';

            $user->$setter($user->$getter() - $playerValue);

            $this->userRepository->updateUser($user);
            return true;
        }

        return false;
    }

    public function findUsersPlayers(array $array)
    {
        $players = [];

        foreach ($array as $udp){
            $player = $udp->getPlayerId();
            $players[$player->getName()] = $player;
        }

        return $players;
    }
}