<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

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
        }
        return $this->render('security/register.html.twig', [
            'form'=> $form->createView()
        ]);
    }

}
