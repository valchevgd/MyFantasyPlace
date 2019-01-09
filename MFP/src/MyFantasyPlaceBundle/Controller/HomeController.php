<?php

namespace MyFantasyPlaceBundle\Controller;

use MyFantasyPlaceBundle\Service\Players\PlayersServiceInterface;
use MyFantasyPlaceBundle\Service\Tournament\TournamentServiceInterface;
use MyFantasyPlaceBundle\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var PlayersServiceInterface
     */
    private $playerService;

    /**
     * @var TournamentServiceInterface
     */
    private $tournamentService;

    /**
     * @param UserServiceInterface $userService
     * @param PlayersServiceInterface $playerService
     * @param TournamentServiceInterface $tournamentService
     */
    public function __construct(UserServiceInterface $userService,
                                PlayersServiceInterface $playerService,
                                TournamentServiceInterface $tournamentService)
    {
        $this->userService = $userService;
        $this->playerService = $playerService;
        $this->tournamentService = $tournamentService;
    }


    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $usersSnookerRank = $this->userService->getRank('snooker', 'season' ,5);
        $usersDartsRank = $this->userService->getRank('darts', 'season',5);
        $playersSnookerRank = $this->playerService->getRank('snooker');
        $playersDartsRank = $this->playerService->getRank('darts');
        $nextSnookerTournament = $this->tournamentService->getNext('snooker');
        $nextDartsTournament = $this->tournamentService->getNext('darts');
        $runningSnookerTournament = $this->tournamentService->getCurrentTournament('snooker');
        $runningDartsTournament = $this->tournamentService->getCurrentTournament('darts');

        return $this->render("home/index.html.twig", [
            'usersSnookerRank' => $usersSnookerRank,
            'usersDartsRank' => $usersDartsRank,
            'playersSnookerRank' => $playersSnookerRank,
            'playersDartsRank' => $playersDartsRank,
            'snookerTournament' => $nextSnookerTournament,
            'dartsTournament' => $nextDartsTournament,
            'runningSnookerTournament' => $runningSnookerTournament,
            'runningDartsTournament' => $runningDartsTournament
        ]);
    }
}
