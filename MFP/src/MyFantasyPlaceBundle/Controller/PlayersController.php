<?php

namespace MyFantasyPlaceBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use MyFantasyPlaceBundle\DTO\DartsPlayerToUpdateDTO;
use MyFantasyPlaceBundle\DTO\PlayersDTO;
use MyFantasyPlaceBundle\Entity\DartsPlayer;
use MyFantasyPlaceBundle\Entity\SnookerPlayer;
use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Form\AddPlayerType;
use MyFantasyPlaceBundle\Form\RemoveDartsPlayerType;
use MyFantasyPlaceBundle\Form\SelectDartsPlayerType;
use MyFantasyPlaceBundle\Form\UpdateDartsPlayerType;
use MyFantasyPlaceBundle\Service\Players\PlayersServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PlayersController extends Controller
{

    /**
     * @var PlayersServiceInterface
     */
    private $playersService;

    /**
     * PlayersController constructor.
     * @param PlayersServiceInterface $dartsService
     */
    public function __construct(PlayersServiceInterface $dartsService)
    {
        $this->playersService = $dartsService;
    }


    /**
     * @Route("/add_player/{type}", name="add_player")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param string $type
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request, string $type)
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user->getIsAdmin()) {
            return $this->redirectToRoute('index');
        }

        $playerType = 'MyFantasyPlaceBundle\Entity\\'.ucfirst($type).'Player';
        $player = new $playerType();
        $form = $this->createForm(AddPlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {

            try {
                if ($this->playersService->addPlayer($player, $type)) {
                    $this->addFlash('message', 'Player added successfully');
                } else {
                    $this->addFlash('message', 'Unsuccessful addition, please try again');
                }
            } catch (UniqueConstraintViolationException $exception) {
                $this->addFlash('message', 'This player is already added!');
            }

            return $this->redirectToRoute('add_player', [
                'type' => $type
            ]);
        }


        return $this->render('admin/add_player.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/remove_players{type}", name="remove_players")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param string $type
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeAction(Request $request, string $type)
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user->getIsAdmin()) {
            return $this->redirectToRoute('index');
        }

        $formType = 'MyFantasyPlaceBundle\Form\Remove'.ucfirst($type).'PlayerType';

        $players = new PlayersDTO();

        $form = $this->createForm($formType, $players);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {

            $playersArray = $players->getPlayers()->toArray();

            $this->playersService->removePlayers($playersArray, $type);

            $this->addFlash('message', 'Players are successfully removed, now is time to add new...');

            return $this->redirectToRoute('add_player', [
                'type' => $type
            ]);

        }

        return $this->render('admin/remove_player.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/update_player/{type}", name="update_player")
     *
     * @param Request $request
     * @param string $type
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function updateValuesAction(Request $request, string $type)
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user->getIsAdmin()) {
            return $this->redirectToRoute('index');
        }
        $formType = 'MyFantasyPlaceBundle\Form\Select'.ucfirst($type).'PlayerType';
        $form = $this->createForm($formType);

        $form->handleRequest($request);
        $dataType = 'MyFantasyPlaceBundle\DTO\\'.ucfirst($type).'PlayerToUpdateDTO';
        $dataFromForm = new $dataType();


        if ($form->isSubmitted()) {
            $player = $form->getData()[$type.'Player'];

            $dataFromForm->setStatus($player->getStatus());
            $dataFromForm->setValue($player->getValue());
            $dataFromForm->setId($player->getId());
        }

        $form2Type = 'MyFantasyPlaceBundle\Form\Update'.ucfirst($type).'PlayerType';
        $form2 = $this->createForm($form2Type, $dataFromForm);

        $form2->handleRequest($request);


        if ($form2->isSubmitted()) {

            $typeToUpdate = 'update'.ucfirst($type).'Player';

            $this->playersService->$typeToUpdate($dataFromForm);
            $this->addFlash('message', 'The player is successfully update!');
           return $this->redirectToRoute('update_player', [
               'type' => $type
           ]);
        }
        return $this->render('admin/update_player.html.twig', [
            'form' => $form->createView(),
            'player' => $dataFromForm,
            'form2' => $form2->createView()
        ]);
    }
}
