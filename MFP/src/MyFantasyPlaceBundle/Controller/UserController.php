<?php

namespace MyFantasyPlaceBundle\Controller;

use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Form\BuyPlayerType;
use MyFantasyPlaceBundle\Form\UserType;
use MyFantasyPlaceBundle\Service\Players\PlayersServiceInterface;
use MyFantasyPlaceBundle\Service\User\UserServiceInterface;
use MyFantasyPlaceBundle\Service\UserPlayer\UserPlayerServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var UserPlayerServiceInterface
     */
    private $userPlayerService;

    /**
     * @var PlayersServiceInterface
     */
    private $playersService;

    /**
     * @param UserServiceInterface $userService
     * @param UserPlayerServiceInterface $userPlayerService
     * @param PlayersServiceInterface $playersService
     */
    public function __construct(UserServiceInterface $userService,
                                UserPlayerServiceInterface $userPlayerService,
                                PlayersServiceInterface $playersService)
    {
        $this->userService = $userService;
        $this->userPlayerService = $userPlayerService;
        $this->playersService = $playersService;
    }


    /**
     * @Route("/register", name="user_register")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {


            try{
                $this->userService->register($user);

            }catch (Exception $exception){
                $this->addFlash('message', $exception->getMessage());
            }

            return $this->redirectToRoute("index");
        }

        return $this->render("user/register.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/buy_player/{type}/{playerId}", name="buy_player")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param string $type
     * @param int $playerId ;
     * @param Request $request
     * @return Response
     */
    public function buyPlayerAction(string $type,int $playerId, Request $request)
    {
        $player = $this->playersService->getPlayer($type, $playerId);
        /** @var User $user */
        $user = $this->getUser();
        $teamValue = 'get'.ucfirst($type).'TeamValue';
        if ($player->getValue() > $user->$teamValue()){
            $this->addFlash('message', 'This player`s value is over your limit, please select other player!');
            return $this->redirectToRoute('view_players', [
                'type' => $type
            ]);
        }
        $typeOfPlayers = 'get'.ucfirst($type).'Players';
        if (count($user->$typeOfPlayers()->toArray()) >= 5){
            $this->addFlash('message', 'You already own 5 players. You can have any more!');
            return $this->redirectToRoute('view_players', [
                'type' => $type
            ]);
        }
        $userPlayers = $this->userPlayerService->findUsersPlayers($user->$typeOfPlayers()->toArray());
        if (array_key_exists($player->getName(), $userPlayers)){
            $this->addFlash('message', 'You already own this player!');
            return $this->redirectToRoute('view_players', [
                'type' => $type
            ]);
        }
        $form = $this->createForm(BuyPlayerType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $typeOfTransfer = 'MyFantasyPlaceBundle\Entity\User'.ucfirst($type).'Player';
            $transfer = new $typeOfTransfer();
            $transfer->setUserId($user);
            $transfer->setPlayerId($player);
            if($this->userPlayerService->makeTransfer($transfer, $type, $user, $player->getValue())){
                $this->addFlash('message', 'You successfully added '.$player->getName().' in your players!');
                return $this->redirectToRoute('view_players', [
                    'type' => $type,
                ]);
            }
        }

        return $this->render('player/buy_player.html.twig', [
            'player' => $player,
            'form' => $form->createView(),
        ]);
    }


}
