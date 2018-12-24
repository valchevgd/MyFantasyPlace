<?php

namespace MyFantasyPlaceBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use MyFantasyPlaceBundle\Entity\DartsPlayer;
use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Form\AddPlayerType;
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

        if (!$user->getIsAdmin()){
            return $this->redirectToRoute('index');
        }

        $player = new DartsPlayer();
        $form = $this->createForm(AddPlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()){

            try {
                if ($this->dartsService->addPlayer($player)) {
                    $this->addFlash('message', 'Player added successfully');
                }else{
                    $this->addFlash('message', 'Unsuccessful addition, please try again');
                }
            }catch (UniqueConstraintViolationException $exception){
                $this->addFlash('message', 'This player is already added!');
            }

            return $this->redirectToRoute('add_darts_player');
        }


        return $this->render('darts/add_player.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
