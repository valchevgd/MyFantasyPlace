<?php

namespace MyFantasyPlaceBundle\Controller;

use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @Route("register", name="user_register")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($request){
            var_dump($user);
        }

        return $this->render("user/register.html.twig", [
            'form' => $form->createView()
        ]);
    }
}
