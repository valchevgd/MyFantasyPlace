<?php

namespace MyFantasyPlaceBundle\Controller;

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
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }


    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $usersSnookerRank = $this->userService->getSnookerRank();
        $usersDartsRank = $this->userService->getDartsRank();

        return $this->render("home/index.html.twig", [
            'snookerRank' => $usersSnookerRank,
            'dartsRank' => $usersDartsRank
        ]);
    }
}
