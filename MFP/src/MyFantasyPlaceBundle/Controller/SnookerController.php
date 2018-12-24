<?php

namespace MyFantasyPlaceBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use MyFantasyPlaceBundle\DTO\PlayersToRemoveDTO;
use MyFantasyPlaceBundle\Entity\SnookerPlayer;
use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Form\AddPlayerType;
use MyFantasyPlaceBundle\Form\RemovePlayerType;
use MyFantasyPlaceBundle\Service\Snooker\SnookerServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SnookerController extends Controller
{
    /**
     * @var SnookerServiceInterface
     */
    private $snookerService;

    /**
     * SnookerController constructor.
     * @param SnookerServiceInterface $snookerService
     */
    public function __construct(SnookerServiceInterface $snookerService)
    {
        $this->snookerService = $snookerService;
    }


    /**
     * @Route("/addSnookerPlayer", name="add_snooker_player")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user->getIsAdmin()){
            return $this->redirectToRoute('index');
        }

        $player = new SnookerPlayer();
        $form = $this->createForm(AddPlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()){
            try {
                if ($this->snookerService->addPlayer($player)) {
                    $this->addFlash('message', 'Player added successfully');
                }else{
                    $this->addFlash('message', 'Unsuccessful addition, please try again');
                }
            }catch (UniqueConstraintViolationException $exception){
                $this->addFlash('message', 'This player is already added!');
            }

            return $this->redirectToRoute('add_snooker_player');
        }

        return $this->render('snooker/add_player.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/removePlayer", name="remove_snooker_player")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user->getIsAdmin()){
            return $this->redirectToRoute('index');
        }

        $players = new PlayersToRemoveDTO();

        $form = $this->createForm(RemovePlayerType::class, $players);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()){

            $playersArray = $players->getPlayers()->toArray();

            $this->snookerService->removePlayers($playersArray);

            $this->addFlash('message', 'Players are successfully removed, now is time to add new...');

            return $this->redirectToRoute('add_snooker_player');

        }

        return $this->render('snooker/remove_player.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
