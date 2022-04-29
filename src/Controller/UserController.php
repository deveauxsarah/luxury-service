<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\User;
use App\Form\UserType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager
            ->getRepository(User::class)
            ->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/profile', name: 'app_profile', methods: ['GET', 'POST'])]
    public function show(): Response
    {
        // usually you'll want to make sure the user is authenticated first,
        // see "Authorization" below
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // Call whatever methods you've added to your User class
        // For example, if you added a getFirstName() method, you can use that.
        // return new Response('Well hi there '. $user->getEmail());
        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profile/edit/{id}', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        // $userId = $request->query->get('id');
        // $user = $doctrine->getRepository(User::class)->findOneBy(['id' => $userId]);
        // dd($user);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $categories = $doctrine->getRepository(Categorie::class)->findAll();

        $category = $form->get('categorie')->getData();
        $gender = $form->get('gender')->getData();
        $firstName = $form->get('firstName')->getData();
        $lastName = $form->get('lastName')->getData();
        $location = $form->get('location')->getData();
        $address = $form->get('address')->getData();
        $country = $form->get('country')->getData();
        $nationality = $form->get('nationality')->getData();
        $birthdate = $form->get('birthdate')->getData();
        $birthplace = $form->get('birthplace')->getData();
        $experience = $form->get('experience')->getData();
        $description = $form->get('description')->getData();
        
        $array = (array) $form->getData();
        $info = 0;
        $total = 0;
        foreach ($array as $key => $value) {
           if ($value !== null){
                $total++;
                $info++;
           }else{
               $total++;
           }
        }
        $percent =  $info/$total*100;
        
        if ($form->isSubmitted() && $form->isValid()) {
            if ($percent == 100) {
                $user->setDisponibility(1);
            }
            
            $user->setGender($gender);
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setLocation($location);
            $user->setAddress($address);
            $user->setCountry($country);
            $user->setNationality($nationality);
            $user->setBirthdate($birthdate);
            $user->setBirthplace($birthplace);
            // $user->setPicture();
            // $user->setPassport();
            // $user->setCv();
            // $user->setFile();
            $user->setExperience($experience);
            $user->setDescription($description);
            $user->setCategorie($category);
            $user->setUpdatedAt(new DateTime());
            
            $entityManager->flush();
            
            return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'percent' => round($percent),
            'categories' => $categories,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
