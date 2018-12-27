<?php

namespace MyFantasyPlaceBundle\Controller;

use MyFantasyPlaceBundle\DTO\PlayersDTO;
use MyFantasyPlaceBundle\Entity\Tournament;
use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Form\AddTournamentType;
use MyFantasyPlaceBundle\Form\RemoveDartsPlayerType;
use MyFantasyPlaceBundle\Form\RemoveSnookerPlayerType;
use MyFantasyPlaceBundle\Service\Tournament\TournamentServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TournamentsController extends Controller
{
    /** @var TournamentServiceInterface */
    private $tournamentService;

    /**
     * TournamentsController constructor.
     * @param TournamentServiceInterface $tournamentService
     */
    public function __construct(TournamentServiceInterface $tournamentService)
    {
        $this->tournamentService = $tournamentService;
    }


    /**
     * @Route("/add_tournament/{type}", name="add_tournament")
     *
     * @param $type
     * @param Request $request
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request, string $type)
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user->getIsAdmin()) {
            return $this->redirectToRoute('index');
        }

        $tournament = new Tournament();
        $form = $this->createForm(AddTournamentType::class, $tournament);
        $form->handleRequest($request);
        $tournament->setType($type);
        if ($form->isSubmitted() and $form->isValid()){
            if ($this->tournamentService->addTournament($tournament)){
                $this->addFlash('message', 'Tournament are successfully added');
            }

            return $this->redirectToRoute('add_tournament', [
                'type' => $type
            ]);
        }

        return $this->render('admin/add_tournament.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/start_tournament/{type}", name="start_tournament")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param string $type
     * @return Response
     */
    public function startAction(Request $request, string $type)
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user->getIsAdmin()) {
            return $this->redirectToRoute('index');
        }


        $nextTournament = $this->tournamentService->getNext($type);
        $formType = 'MyFantasyPlaceBundle\Form\Remove'.ucfirst($type).'PlayerType';

        $players = new PlayersDTO();

        $form = $this->createForm($formType, $players);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            var_dump($players->getPlayers()->toArray());
        }

        return $this->render('admin/start_tournament.html.twig',[
            'type' => $nextTournament,
            'form' => $form->createView()
        ]);
    }
}
