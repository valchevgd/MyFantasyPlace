<?php

namespace MyFantasyPlaceBundle\Controller;

use MyFantasyPlaceBundle\Service\Players\PlayersServiceInterface;
use MyFantasyPlaceBundle\Service\User\UserServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends Controller
{
    /**
     * @var PlayersServiceInterface
     */
    private $playersService;

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * StatsController constructor.
     * @param PlayersServiceInterface $playersService
     * @param UserServiceInterface $userService
     */
    public function __construct(PlayersServiceInterface $playersService,
                                UserServiceInterface $userService)
    {
        $this->playersService = $playersService;
        $this->userService = $userService;
    }


    /**
     * @Route("/statistic/{type}_{order}", name="statistic")
     *
     * @param $type
     * @param $order
     *
     * @return Response
     */
    public function showPlayersStatsAction($type, $order)
    {

        $players = $this->playersService->getAllPlayers($type, $order);

        return $this->render("player/".$type."_statistic.html.twig", [
            'type' => $type,
            'order' => $order,
            'players' => $players
        ]);
    }

    /**
     * @Route("/standing/{type}", name="standing")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $type
     * @return Response
     */
    public function showUsersStandingAction($type)
    {
        $usersRanking = $this->userService->getRank($type);

        return $this->render('statistic/standing.html.twig',[
            'userRank' => $usersRanking,
            'type' => $type
        ]);
    }
}
