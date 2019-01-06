<?php

namespace MyFantasyPlaceBundle\Controller;

use MyFantasyPlaceBundle\DTO\PlayerToViewDTO;
use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Form\BuyPlayerType;
use MyFantasyPlaceBundle\Form\UpgradePlayerType;
use MyFantasyPlaceBundle\Service\Players\PlayersServiceInterface;
use MyFantasyPlaceBundle\Service\UserPlayer\UserPlayerServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserPlayerController extends Controller
{

    /**
     * @var UserPlayerServiceInterface
     */
    private $userPlayerService;

    /**
     * @var PlayersServiceInterface
     */
    private $playersService;

    const LIMIT = 1;

    /**
     * @param UserPlayerServiceInterface $userPlayerService
     * @param PlayersServiceInterface $playersService
     */
    public function __construct(UserPlayerServiceInterface $userPlayerService,
                                PlayersServiceInterface $playersService)
    {
        $this->userPlayerService = $userPlayerService;
        $this->playersService = $playersService;
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
    public function buyPlayerAction(string $type, int $playerId, Request $request)
    {
        $player = $this->playersService->getPlayer($type, $playerId);
        /** @var User $user */
        $user = $this->getUser();
        $teamValue = 'get' . ucfirst($type) . 'TeamValue';
        if ($player->getValue() > $user->$teamValue()) {
            $this->addFlash('message', 'This player`s value is over your limit, please select other player!');
            return $this->redirectToRoute('view_players', [
                'type' => $type
            ]);
        }
        $typeOfPlayers = 'get' . ucfirst($type) . 'Players';
        if (count($user->$typeOfPlayers()->toArray()) >= 5) {
            $this->addFlash('message', 'You already own 5 players. You can have any more!');
            return $this->redirectToRoute('view_players', [
                'type' => $type
            ]);
        }
        $userPlayers = $this->userPlayerService->findUsersPlayers($user->$typeOfPlayers()->toArray());
        if (array_key_exists($player->getName(), $userPlayers)) {
            $this->addFlash('message', 'You already own this player!');
            return $this->redirectToRoute('view_players', [
                'type' => $type
            ]);
        }
        $form = $this->createForm(BuyPlayerType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $typeOfTransfer = 'MyFantasyPlaceBundle\Entity\User' . ucfirst($type) . 'Player';
            $transfer = new $typeOfTransfer();
            $transfer->setUserId($user);
            $transfer->setPlayerId($player);
            if ($this->userPlayerService->makeTransfer($transfer, $type, $user, $player->getValue())) {
                $this->addFlash('message', 'You successfully added ' . $player->getName() . ' in your players!');
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

    /**
     * @Route("/upgrade_players/{type}", name="upgrade_players")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param string $type
     * @return Response
     */
    public function upgradePlayersAction(string $type, Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();

        /** @var PlayerToViewDTO[] $userPlayers */
        $userPlayers = $this->userPlayerService->getPlayersToView($user->getId(), $type);

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $userPlayers,
            $request->query->getInt('page', 1),
            self::LIMIT
        );
        $form = $this->createForm(UpgradePlayerType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $tokens = $form->getData()['tokens'];
            $playerId = $form->getData()['id'];
            try {
                if($this->userPlayerService->upgradePlayer($user, $playerId, $type, $tokens)){
                    return $this->redirectToRoute('upgrade_players', [
                        'type' => $type,
                        'pagination' => $pagination,
                        'form' => $form->createView()
                    ]);
                }
            } catch (\Exception $exception) {
                $this->addFlash('message', $exception->getMessage());
                return $this->redirectToRoute('upgrade_players', [
                    'type' => $type,
                    'pagination' => $pagination,
                    'form' => $form->createView()
                ]);
            }
        }


        return $this->render('player/upgrade_players.html.twig', [
            'type' => $type,
            'pagination' => $pagination,
            'form' => $form->createView()

        ]);
    }

    /**
     * @Route("/remove_players/{type}", name="remove_players")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param string $type
     * @return Response
     */
    public function showPlayersToRemoveAction(string $type)
    {
        /** @var User $user */
        $user = $this->getUser();

        $players = $this->userPlayerService->getPlayersToView($user->getId(), $type);

        return $this->render('player/remove_players.html.twig',[
            'type' => $type,
            'players' => $players
        ]);
    }

    /**
     * @Route("remove_player/{type}/{playerId}", name="remove_player")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param string $type
     * @param int $playerId
     * @return Response
     */
    public function removePlayerAction(Request $request, string $type, int $playerId)
    {
        /** @var User $user */
        $user = $this->getUser();

        /** @var PlayerToViewDTO $players */
        $player = $this->userPlayerService->getPlayerToView($user->getId(), $type, $playerId);

        if ($request->getMethod() === 'POST'){
            try{
                if($this->userPlayerService->remove($user, $type, $playerId, $player['value'])){
                    $this->addFlash('message', 'You successfully remove ' . $player['name'] . ' from your players!');
                    return $this->redirectToRoute('remove_players', [
                        'type' => $type
                    ]);
                }else{
                    $this->addFlash('message', 'Something went wrong!');
                    return $this->redirectToRoute('remove_players', [
                        'type' => $type
                    ]);
                }
            }catch (\Exception $exception){
                $this->addFlash('message', $exception->getMessage());
                return $this->redirectToRoute('remove_players', [
                    'type' => $type
                ]);
            }

        }

        return $this->render('player/remove_player.html.twig', [
            'type' => $type,
            'player' => $player,
        ]);
    }
}
