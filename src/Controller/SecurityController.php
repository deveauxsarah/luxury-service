<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/register', name: 'security_register', methods: ['GET', 'POST'])]
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher)
    {
        $user = new User();
        
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security_login');
        }
        return $this->render('security/register.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    #[Route('/login', name: 'security_login', methods: [ 'GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils, ManagerRegistry $doctrine, Request $request): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $users = $doctrine->getRepository(User::class)->find($lastUsername);

        return $this->render('security/login.html.twig', [
            'controller_name' => 'SecurityController',
            'last_username' => $lastUsername,
            'error' => $error,
            'users' => $users
          ]);
    }

    #[Route('/logout', name: 'security_logout', methods: [ 'GET', 'POST'])]
    public function logout() {}

}
