<?php

namespace MyFantasyPlaceBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use MyFantasyPlaceBundle\DTO\PlayersDTO;
use MyFantasyPlaceBundle\Form\AddPlayerType;
use MyFantasyPlaceBundle\Form\UpdateValueType;
use MyFantasyPlaceBundle\Service\Players\PlayersServiceInterface;
use MyFantasyPlaceBundle\Service\UserPlayer\UserPlayerServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayersController extends Controller
{

    /**
     * @var PlayersServiceInterface
     */
    private $playersService;

    /**
     * @var UserPlayerServiceInterface
     */
    private $userPlayerService;

    /**
     * PlayersController constructor.
     * @param PlayersServiceInterface $dartsService
     * @param UserPlayerServiceInterface $userPlayerService
     */
    public function __construct(PlayersServiceInterface $dartsService,
                                UserPlayerServiceInterface $userPlayerService)
    {
        $this->playersService = $dartsService;
        $this->userPlayerService = $userPlayerService;
    }


    /**
     * @Route("/admin_add_player/{type}", name="admin_add_player")
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @param string $type
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request, string $type)
    {
        $playerType = 'MyFantasyPlaceBundle\Entity\\' . ucfirst($type) . 'Player';
        $player = new $playerType();
        $form = $this->createForm(AddPlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            try {
                if ($this->playersService->addPlayer($player, $type)) {
                    $this->addFlash('message', $player->getName() . ' is added successfully');
                } else {
                    $this->addFlash('message', 'Unsuccessful addition, please try again');
                }
            } catch (UniqueConstraintViolationException $exception) {
                $this->addFlash('message', $player->getName() . ' is already added!');
            }

            return $this->redirectToRoute('admin_add_player', [
                'type' => $type
            ]);
        }

        return $this->render('player/add_player.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin_remove_players{type}", name="admin_remove_players")
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @param string $type
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeAction(Request $request, string $type)
    {
        $formType = 'MyFantasyPlaceBundle\Form\Remove' . ucfirst($type) . 'PlayerType';
        $players = new PlayersDTO();
        $form = $this->createForm($formType, $players);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {


            if ($this->playersService->removePlayers($players, $type)) {
                $this->addFlash('message', 'Players are successfully removed, now is time to add new...');
            } else {
                $this->addFlash('message', 'something went wrong');
            }

            return $this->redirectToRoute('admin_add_player', [
                'type' => $type
            ]);
        }

        return $this->render('player/remove_players.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin_update_player_results/{type}", name="admin_update_players_results")
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @param string $type
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateResultsAction(Request $request, string $type)
    {
        $formType = 'MyFantasyPlaceBundle\Form\Select' . ucfirst($type) . 'PlayerType';
        $form = $this->createForm($formType);

        $form->handleRequest($request);
        $dataType = 'MyFantasyPlaceBundle\DTO\\' . ucfirst($type) . 'PlayerToUpdateDTO';
        $dataFromForm = new $dataType();

        if ($form->isSubmitted()) {
            $player = $form->getData()['player'];

            $dataFromForm->setStatus($player->getStatus());
            $dataFromForm->setId($player->getId());
        }

        $form2Type = 'MyFantasyPlaceBundle\Form\Update' . ucfirst($type) . 'PlayerType';
        $form2 = $this->createForm($form2Type, $dataFromForm);

        $form2->handleRequest($request);

        if ($form2->isSubmitted()) {

            $typeToUpdate = 'update' . ucfirst($type) . 'Player';

            try {
                if ($this->playersService->$typeToUpdate($dataFromForm)) {
                    $this->addFlash('message', 'The player is successfully update!');
                } else {
                    $this->addFlash('message', 'Unsuccessfully update! Please try again.');
                }

            } catch (\Exception $exception) {
                $this->addFlash('message', $exception->getMessage());
            }

            return $this->redirectToRoute('admin_update_players_results', [
                'type' => $type
            ]);
        }
        return $this->render('player/update_player_results.html.twig', [
            'form' => $form->createView(),
            'player' => $dataFromForm,
            'form2' => $form2->createView(),
        ]);
    }


    /**
     * @Route("admin_update_players_value/{type}", name="update_players_value")
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @param string $type
     * @return Response
     */
    public function updateValueAction(Request $request, string $type)
    {

        $player = $this->playersService->getPlayerToUpdate($type);

        $form = $this->createForm(UpdateValueType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {

            try {
                if ($this->playersService->updateValue($player, $type)) {
                    $this->addFlash('message', $player->getName() . '`s value is successfully update!');
                } else {
                    $this->addFlash('message', 'Unsuccessfully update! Please try again.');
                }
                return $this->redirectToRoute('update_players_value', [
                    'type' => $type
                ]);
            } catch (\Exception $exception) {
                $this->addFlash('message', $exception->getMessage());
                return $this->redirectToRoute('admin_update_players_results', [
                    'type' => $type
                ]);
            }
        }

        return $this->render('player/update_player_value.html.twig', [
            'player' => $player,
            'form' => $form->createView(),
            'type' => $type
        ]);
    }

}
