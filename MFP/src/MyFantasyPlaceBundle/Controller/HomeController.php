<?php

namespace MyFantasyPlaceBundle\Controller;

use MyFantasyPlaceBundle\Service\Players\PlayersServiceInterface;
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
     * @param UserServiceInterface $userService
     * @param PlayersServiceInterface $playerService
     */
    public function __construct(UserServiceInterface $userService,
                                PlayersServiceInterface $playerService)
    {
        $this->userService = $userService;
        $this->playerService = $playerService;
    }


    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $usersSnookerRank = $this->userService->getSnookerRank();
        $usersDartsRank = $this->userService->getDartsRank();
        $playersSnookerRank = $this->playerService->getRank('snooker');
        $playersDartsRank = $this->playerService->getRank('darts');

        return $this->render("home/index.html.twig", [
            'usersSnookerRank' => $usersSnookerRank,
            'usersDartsRank' => $usersDartsRank,
            'playersSnookerRank' => $playersSnookerRank,
            'playersDartsRank' => $playersDartsRank
        ]);
    }
}
