<?php

namespace MyFantasyPlaceBundle\Controller;

use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Form\UserType;
use MyFantasyPlaceBundle\Service\User\UserServiceInterface;
use MyFantasyPlaceBundle\Service\UserPlayer\UserPlayerServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var UserPlayerServiceInterface
     */
    private $userPlayerService;

    /**
     * @param UserServiceInterface $userService
     * @param UserPlayerServiceInterface $userPlayerService
     */
    public function __construct(UserServiceInterface $userService,
                                UserPlayerServiceInterface $userPlayerService)
    {
        $this->userService = $userService;
        $this->userPlayerService = $userPlayerService;

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

    /**
     * @Route("/user_profile/{id}", name="profile")
     *
     * @param Request $request
     * @param int $id
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return Response
     */
    public function viewProfileAction(int $id, Request $request)
    {
        /** @var User $viewUser */
        $viewUser = $this->userService->getViewUser($id);

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        $snookerPlayers = $this->userPlayerService->findUsersPlayers($viewUser->getSnookerPlayers()->toArray());
        $dartsPlayers = $this->userPlayerService->findUsersPlayers($viewUser->getDartsPlayers()->toArray());

        if ($form->isSubmitted() and $form->isValid()){

            /** @var UploadedFile $file */
            $file = $form->get('image')->getData();
            $username = $form->get('username')->getData();
            $email = $form->get('email')->getData();

            $currentUser = $this->userService->prepareUser($currentUser, $username, $email,  $file);

            if($this->userService->update($currentUser)){
                return $this->redirectToRoute('profile', [
                    'id' => $id
                ]);
            }
        }

        return $this->render('user/profile.html.twig', [
            'snookerPlayers' => $snookerPlayers,
            'dartsPlayers' => $dartsPlayers,
            'viewUser' => $viewUser,
            'form' => $form->createView()

        ]);
    }

}
