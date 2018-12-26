<?php

namespace MyFantasyPlaceBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use MyFantasyPlaceBundle\DTO\PlayersDTO;
use MyFantasyPlaceBundle\DTO\SnookerPlayerToUpdateDTO;
use MyFantasyPlaceBundle\Entity\SnookerPlayer;
use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Form\AddPlayerType;
use MyFantasyPlaceBundle\Form\RemoveSnookerPlayerType;
use MyFantasyPlaceBundle\Form\SelectSnookerPlayerType;
use MyFantasyPlaceBundle\Form\UpdateSnookerPlayerType;
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

        if (!$user->getIsAdmin()) {
            return $this->redirectToRoute('index');
        }

        $player = new SnookerPlayer();
        $form = $this->createForm(AddPlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            try {
                if ($this->snookerService->addPlayer($player)) {
                    $this->addFlash('message', 'Player added successfully');
                } else {
                    $this->addFlash('message', 'Unsuccessful addition, please try again');
                }
            } catch (UniqueConstraintViolationException $exception) {
                $this->addFlash('message', 'This player is already added!');
            }

            return $this->redirectToRoute('add_snooker_player');
        }

        return $this->render('admin/add_player.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/removeSnookerPlayer", name="remove_snooker_player")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user->getIsAdmin()) {
            return $this->redirectToRoute('index');
        }

        $players = new PlayersDTO();

        $form = $this->createForm(RemoveSnookerPlayerType::class, $players);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {

            $playersArray = $players->getPlayers()->toArray();

            $this->snookerService->removePlayers($playersArray);

            $this->addFlash('message', 'Players are successfully removed, now is time to add new...');

            return $this->redirectToRoute('add_snooker_player');

        }

        return $this->render('admin/remove_player.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/updateSnookerPlayers", name="update_snooker_players")
     *
     * @param Request $request
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updatePlayerAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user->getIsAdmin()) {
            return $this->redirectToRoute('index');
        }

        $form = $this->createForm(SelectSnookerPlayerType::class);

        $form->handleRequest($request);
        $dataFromForm = new SnookerPlayerToUpdateDTO();


        if ($form->isSubmitted()) {
            $snookerPlayer = $form->getData()['snookerPlayer'];

            $dataFromForm->setStatus($snookerPlayer->getStatus());
            $dataFromForm->setValue($snookerPlayer->getValue());
            $dataFromForm->setId($snookerPlayer->getId());
        }

        $form2 = $this->createForm(UpdateSnookerPlayerType::class, $dataFromForm);

        $form2->handleRequest($request);


        if ($form2->isSubmitted()) {
            $this->snookerService->updatePlayer($dataFromForm);

            return $this->redirectToRoute('update_snooker_players');
        }
        return $this->render('admin/update_player.html.twig', [
            'form' => $form->createView(),
            'player' => $dataFromForm,
            'form2' => $form2->createView()
        ]);
    }
}
