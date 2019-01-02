<?php


namespace MyFantasyPlaceBundle\Service\UserPlayer;


use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Repository\UserDartsPlayerRepository;
use MyFantasyPlaceBundle\Repository\UserRepository;
use MyFantasyPlaceBundle\Repository\UserSnookerPlayerRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

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

    public function getPlayersToView(int $id, string $type)
    {
        $repository = 'user'.ucfirst($type).'PlayerRepository';
        $playersToView = $this->$repository->findPlayersToView($id);

        usort($playersToView, function ($p1, $p2){
            return $p2['value'] <=> $p1['value'];
        });
        return $playersToView;
    }

    public function upgradePlayer(User $user, int $playerId, string $type, float $tokens = null)
    {
        if ($user->getFantasyTokens() < $tokens){
            throw new Exception('You do not have enough tokens!');
        }

        $repository = 'user'.ucfirst($type).'PlayerRepository';

        $startingTokens = $tokens;

        $relation = $this->$repository->findOneBy(['userId' => $user->getId(), 'playerId' => $playerId]);

        $progress = $relation->getProgress();
        $level = $relation->getLevel();
        $value = $relation->getValue();

        while ($tokens > 0){

            if ($tokens > $value){
                $tokens -= $value;
                $level += 0.1;
                $value += 1000;
            }elseif ($progress + $tokens >= $value){
                $progress = ($progress + $tokens) - $value;
                $level += 0.1;
                $value += 1000;
                $tokens = 0;
            }else{
                $progress += $tokens;
                $tokens = 0;
            }
        }

        $relation->setLevel($level);
        $relation->setValue($value);
        $relation->setProgress($progress);

        if($this->$repository->update($relation)){
            $user->setFantasyTokens($user->getFantasyTokens() - $startingTokens);

            $this->userRepository->updateUser($user);

            return true;
        }else{
            throw new Exception('Something went wrong!');
        }
    }

    public function getPlayerToView(int $userId, string $type, int $playerId)
    {
        $repository = 'user'.ucfirst($type).'PlayerRepository';
        $playerToView = $this->$repository->findPlayerToView($userId, $playerId);

        return $playerToView;
    }

    public function remove(User $user, string $type, int $playerId, float $playerValue)
    {
        $repository = 'user'.ucfirst($type).'PlayerRepository';
        $relation = $this->$repository->findOneBy(['userId' => $user->getId(), 'playerId' => $playerId]);

        if($this->$repository->delete($relation)){
            $getter = 'get'.ucfirst($type).'TeamValue';
            $setter = 'set'.ucfirst($type).'TeamValue';

            $user->$setter($user->$getter() + $playerValue);

            $this->userRepository->updateUser($user);
            return true;
        }

        return false;
    }

}