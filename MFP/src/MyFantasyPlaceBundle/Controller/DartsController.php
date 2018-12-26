<?php

namespace MyFantasyPlaceBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use MyFantasyPlaceBundle\DTO\DartsPlayerToUpdateDTO;
use MyFantasyPlaceBundle\DTO\PlayersDTO;
use MyFantasyPlaceBundle\Entity\DartsPlayer;
use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Form\AddPlayerType;
use MyFantasyPlaceBundle\Form\RemoveDartsPlayerType;
use MyFantasyPlaceBundle\Form\SelectDartsPlayerForm;
use MyFantasyPlaceBundle\Form\UpdateDartsPlayerType;
use MyFantasyPlaceBundle\Service\Darts\DartsServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DartsController extends Controller
{

    /**
     * @var DartsServiceInterface
     */
    private $dartsService;

    /**
     * DartsController constructor.
     * @param DartsServiceInterface $dartsService
     */
    public function __construct(DartsServiceInterface $dartsService)
    {
        $this->dartsService = $dartsService;
    }


    /**
     * @Route("/addDartsPlayer", name="add_darts_player")
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

        $player = new DartsPlayer();
        $form = $this->createForm(AddPlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {

            try {
                if ($this->dartsService->addPlayer($player)) {
                    $this->addFlash('message', 'Player added successfully');
                } else {
                    $this->addFlash('message', 'Unsuccessful addition, please try again');
                }
            } catch (UniqueConstraintViolationException $exception) {
                $this->addFlash('message', 'This player is already added!');
            }

            return $this->redirectToRoute('add_darts_player');
        }


        return $this->render('admin/add_player.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/removeDartsPlayer", name="remove_darts_player")
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

        $form = $this->createForm(RemoveDartsPlayerType::class, $players);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {

            $playersArray = $players->getPlayers()->toArray();

            $this->dartsService->removePlayers($playersArray);

            $this->addFlash('message', 'Players are successfully removed, now is time to add new...');

            return $this->redirectToRoute('add_darts_player');

        }

        return $this->render('admin/remove_player.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/updateDartsPlayers", name="update_darts_players")
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

        $form = $this->createForm(SelectDartsPlayerForm::class);

        $form->handleRequest($request);
        $dataFromForm = new DartsPlayerToUpdateDTO();


        if ($form->isSubmitted()) {
            $dartsPlayer = $form->getData()['dartsPlayer'];

            $dataFromForm->setStatus($dartsPlayer->getStatus());
            $dataFromForm->setValue($dartsPlayer->getValue());
            $dataFromForm->setId($dartsPlayer->getId());
        }

        $form2 = $this->createForm(UpdateDartsPlayerType::class, $dataFromForm);

        $form2->handleRequest($request);


        if ($form2->isSubmitted()) {

            $this->dartsService->updatePlayer($dataFromForm);

           return $this->redirectToRoute('update_darts_players');
        }
        return $this->render('admin/update_player.html.twig', [
            'form' => $form->createView(),
            'player' => $dataFromForm,
            'form2' => $form2->createView()
        ]);
    }
}
