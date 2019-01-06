<?php

namespace MyFantasyPlaceBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use MyFantasyPlaceBundle\DTO\PlayersDTO;
use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Form\AddPlayerType;
use MyFantasyPlaceBundle\Form\UpdateValueType;
use MyFantasyPlaceBundle\Service\Players\PlayersServiceInterface;
use MyFantasyPlaceBundle\Service\UserPlayer\UserPlayerServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
                    $this->addFlash('message', $player->getName(). ' is added successfully');
                } else {
                    $this->addFlash('message', 'Unsuccessful addition, please try again');
                }
            } catch (UniqueConstraintViolationException $exception) {
                $this->addFlash('message', $player->getName(). ' is already added!');
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
     * @Route("/admin_remove_players{type}", name="admin_remove_players")
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
     * @Route("/update_player/{type}", name="update_players_results")
     *
     * @param Request $request
     * @param string $type
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function updateResultsAction(Request $request, string $type)
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
            $player = $form->getData()['player'];

            $dataFromForm->setStatus($player->getStatus());
            $dataFromForm->setId($player->getId());
        }

        $form2Type = 'MyFantasyPlaceBundle\Form\Update'.ucfirst($type).'PlayerType';
        $form2 = $this->createForm($form2Type, $dataFromForm);

        $form2->handleRequest($request);


        if ($form2->isSubmitted()) {

            $typeToUpdate = 'update'.ucfirst($type).'Player';

            try {
                $this->playersService->$typeToUpdate($dataFromForm);
                $this->addFlash('message', 'The player is successfully update!');
                return $this->redirectToRoute('update_players_results', [
                    'type' => $type
                ]);
            }catch (\Exception $exception){
                $this->addFlash('message', $exception->getMessage());
                return $this->redirectToRoute('update_players_results', [
                    'type' => $type
                ]);
            }
        }
        return $this->render('admin/update_player.html.twig', [
            'form' => $form->createView(),
            'player' => $dataFromForm,
            'form2' => $form2->createView(),
        ]);
    }

    /**
     * @Route("/view_players/{type}", name="view_players")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param string $type
     * @return Response
     */
    public function viewPlayersAction(string $type)
    {
        $user = $this->getUser();

        $allPlayers = $this->playersService->getAllPlayers($type, 'value');
        $typeOfPlayers = 'get'.ucfirst($type).'Players';

        return $this->render('player/view_players.html.twig', [
            'type' => $type,
            'players' => $allPlayers,
            'userPlayers' => $this->userPlayerService->findUsersPlayers($user->$typeOfPlayers()->toArray())
        ]);
    }

    /**
     * @Route("admin_update_players_value/{type}", name="update_players_value")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param string $type
     * @return Response
     */
    public function updateValueAction(Request $request, string $type)
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user->getIsAdmin()) {
            return $this->redirectToRoute('index');
        }

        try{
            $player = $this->playersService->getPlayerToUpdate($type);
        }catch (\Exception $exception){
            $this->addFlash('message', $exception->getMessage());
            return $this->redirectToRoute('update_players_results', [
                'type' => $type
            ]);
        }

        $form = $this->createForm(UpdateValueType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()){

            try {
                if ($this->playersService->updateValue($player, $type)) {
                    $this->addFlash('message', $player->getName().'`s value is successfully update!');
                    return $this->redirectToRoute('update_players_value', [
                        'type' => $type
                    ]);
                }
            }catch (\Exception $exception){
                $this->addFlash('message', $exception->getMessage());
                return $this->redirectToRoute('update_players_results', [
                    'type' => $type
                ]);
            }
        }

        return $this->render('admin/update_value.html.twig', [
            'player' => $player,
            'form' => $form->createView(),
            'type' => $type
        ]);
    }

}
