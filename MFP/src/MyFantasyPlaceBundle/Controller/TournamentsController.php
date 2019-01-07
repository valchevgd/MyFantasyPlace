<?php

namespace MyFantasyPlaceBundle\Controller;

use MyFantasyPlaceBundle\DTO\PlayersDTO;
use MyFantasyPlaceBundle\Entity\Tournament;
use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Form\AddTournamentType;
use MyFantasyPlaceBundle\Form\FinishTournamentType;
use MyFantasyPlaceBundle\Form\UpdateValueType;
use MyFantasyPlaceBundle\Service\Players\PlayersServiceInterface;
use MyFantasyPlaceBundle\Service\Tournament\TournamentServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
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
     * @Security("has_role('ROLE_ADMIN')")
     * @param $type
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request, string $type)
    {

        $tournament = new Tournament();
        $form = $this->createForm(AddTournamentType::class, $tournament);
        $form->handleRequest($request);
        $tournament->setType($type);
        if ($form->isSubmitted() and $form->isValid()) {
            if ($this->tournamentService->addTournament($tournament)) {
                $this->addFlash('message', $tournament->getName() .' is successfully added');
            }

            return $this->redirectToRoute('add_tournament', [
                'type' => $type
            ]);
        }

        return $this->render('tournament/add_tournament.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/start_tournament/{type}", name="start_tournament")
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @param string $type
     * @return Response
     */
    public function startAction(Request $request, string $type)
    {

        /** @var Tournament $nextTournament */
        $nextTournament = $this->tournamentService->getNext($type);
        $formType = 'MyFantasyPlaceBundle\Form\Remove' . ucfirst($type) . 'PlayerType';

        $players = new PlayersDTO();
        $form = $this->createForm($formType, $players);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            try {
                $this->tournamentService->startTournament($nextTournament, $players, $type);
                $this->addFlash('message', $nextTournament->getName() . ' tournament is successfully started. Next tournament is :');
            } catch (Exception $exception) {
                $this->addFlash('message', $exception->getMessage() . ' tournament is already running. Please first finish it!');
                return $this->redirectToRoute('finish_tournament', [
                    'type' => $type
                ]);
            }

            return $this->redirectToRoute('start_tournament', [
                'type' => $type
            ]);
        }

        return $this->render('tournament/start_tournament.html.twig', [
            'tournament' => $nextTournament,
            'form' => $form->createView(),
            'type' => $type
        ]);
    }


    /**
     * @Route("/finish_tournament/{type}", name="finish_tournament")
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @param string $type
     * @return Response
     */
    public function finishAction(Request $request, string $type)
    {
        /** @var Tournament $currentTournament */
        $currentTournament = $this->tournamentService->getCurrentTournament($type);

        $form = $this->createForm(FinishTournamentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()){
            try{
                if($this->tournamentService->finishTournament($currentTournament, $type)){
                    $this->addFlash('message', $currentTournament->getName().' tournament is successfully finished! Now you can start next tournament.');
                    return $this->redirectToRoute('start_tournament', [
                        'type' => $type
                    ]);
                }
            }catch (Exception $exception){
                $this->addFlash('message', $exception->getMessage());
                return $this->redirectToRoute('update_players_results', [
                    'type' => $type
                ]);
            }
        }

        return $this->render('tournament/finish_tournament.html.twig', [
            'tournament' => $currentTournament,
            'form' => $form->createView(),
            'type' => $type
        ]);
    }
}
