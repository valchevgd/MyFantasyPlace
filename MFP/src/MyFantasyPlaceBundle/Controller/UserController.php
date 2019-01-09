<?php

namespace MyFantasyPlaceBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use MyFantasyPlaceBundle\DTO\ChangePasswordDTO;
use MyFantasyPlaceBundle\Entity\User;
use MyFantasyPlaceBundle\Form\ChangePasswordType;
use MyFantasyPlaceBundle\Form\DeleteAccountType;
use MyFantasyPlaceBundle\Form\UserType;
use MyFantasyPlaceBundle\Service\User\UserServiceInterface;
use MyFantasyPlaceBundle\Service\UserPlayer\UserPlayerServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


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

            try {
                $this->userService->register($user);
            } catch (Exception $exception) {
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
        /** @var User $user */
        $user = $this->userService->getViewUser($id);

        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        $snookerPlayers = $this->userPlayerService->findUsersPlayers($user->getSnookerPlayers()->toArray());
        $dartsPlayers = $this->userPlayerService->findUsersPlayers($user->getDartsPlayers()->toArray());

        if ($form->isSubmitted() and $form->isValid()) {

            /** @var UploadedFile $file */
            $file = $form->get('image')->getData();
            $username = $form->get('username')->getData();
            $email = $form->get('email')->getData();

            $user = $this->userService->prepareUser($user, $username, $email, $file);
            try{
                if ($this->userService->update($user)) {
                    $this->addFlash('message', 'Update successful');
                }
            }catch (UniqueConstraintViolationException $exception) {
                $this->addFlash('message', 'Username or email is already taken!');
            }

            return $this->redirectToRoute('profile', [
                'id' => $id
            ]);
        }

        return $this->render('user/profile.html.twig', [
            'snookerPlayers' => $snookerPlayers,
            'dartsPlayers' => $dartsPlayers,
            'viewUser' => $user,
            'form' => $form->createView()

        ]);
    }

    /**
     * @Route("/user_change_password", name="change_password")
     *
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @return Response
     */
    public function changePasswordAction(Request $request)
    {
        $newPassword = new ChangePasswordDTO();

        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class, $newPassword);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {

            if ($this->userService->changePassword($user, $newPassword)) {
                $this->addFlash('message', 'Update successful');
                return $this->redirectToRoute('profile', [
                    'id' => $user->getId()
                ]);
            }
        }

        return $this->render('user/change_password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user_delete", name="user_delete")
     *
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @param TokenStorageInterface $tokenStorage
     * @param SessionInterface $session
     * @return Response
     */
    public function deleteAccountAction(Request $request, TokenStorageInterface $tokenStorage, SessionInterface $session)
    {
        $form = $this->createForm(DeleteAccountType::class);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() and $form->isValid()){
            $password = $form->getData()['password'];

            try{
                $this->userService->deleteUser($user, $password, $tokenStorage, $session);
                return $this->redirectToRoute('index');
            }catch (Exception $exception){
                $this->addFlash('message', $exception->getMessage());
                return $this->redirectToRoute('user_delete');
            }

        }

        return $this->render('user/delete_account.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
