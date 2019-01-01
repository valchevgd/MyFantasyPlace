<?php

namespace MyFantasyPlaceBundle\Controller;

use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Form\UserType;
use MyFantasyPlaceBundle\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
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
     * @Route("/register", name="user_register")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {


            try{
                $this->userService->register($user);
            }catch (Exception $exception){
                $this->addFlash('message', $exception->getMessage());
                return $this->redirectToRoute('user_register');
            }

            return $this->redirectToRoute("security_login");
        }

        return $this->render("user/register.html.twig", [
            'form' => $form->createView()
        ]);
    }


}
