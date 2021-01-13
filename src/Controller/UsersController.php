<?php

namespace App\Controller;

use App\Entity\Week;
use App\Entity\Client;
use App\Form\ProfileType;
use App\Form\EditPasswordType;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersController extends AbstractController
{

    /**
     * @Route("/register", name="user_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $client = new Client();

        $form = $this->createForm(RegistrationType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($client, $client->getPassword());
            $client->setPassword($hash);

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($client);
            $entityManager->flush();
            return $this->RedirectToRoute('user_login');
        }

        return $this->render('users/register.html.twig', [
            'controller_name' => 'UsersController',
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/profile", name="user_profile")
     */
    public function profile(Request $request, Security $security, UserPasswordEncoderInterface $encoder): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $connectedUser = $security->getUser();
        $currentPassword = $connectedUser->getPassword();
        $form = $this->createForm(ProfileType::class, $connectedUser);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($connectedUser);
            $entityManager->flush();
            $this->addFlash('message', 'Profil mis à jour');
        }

        $formPassword = $this->createForm(EditPasswordType::class, $connectedUser);
        $formPassword->handleRequest($request);

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {
            $hash = $encoder->encodePassword($connectedUser, $connectedUser->getPassword());
            $connectedUser->setPassword($hash);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($connectedUser);
            $entityManager->flush();
            $this->addFlash('message', 'Mot de passe mis à jour');
        }


        return $this->render('users/profile.html.twig', [
            'controller_name' => 'UsersController',
            'form' => $form->createView(),
            'formPassword' => $formPassword->createView(),
        ]);
    }

    /**
     * @Route("/login", name="user_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('users/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="user_logout")
     */
    public function logout()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/history", name="user_history")
     */
    public function history(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('users/history.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    /**
     * @Route("/history/{id}/delete", name="week_delete")
    */
    public function deleteWeek(Week $week): RedirectResponse{
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($week);
        $manager->flush();

        return $this->redirectToRoute("user_history");
    }

}
