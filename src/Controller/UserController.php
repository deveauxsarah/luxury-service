<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\User;
use App\Form\UserType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function show(Request $request,  ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        // usually you'll want to make sure the user is authenticated first,
        // see "Authorization" below
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        // $form2 = $this->createForm(ChangePasswordType::class, $this->getUser());
        // $form2->handleRequest($request);

        
        // if ($form2->isSubmitted() && $form2->isValid()) {

        //     $user->setUpdatedAt(new DateTime());
        //     $entityManager->flush();
            
        //     return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
        // }
        // Call whatever methods you've added to your User class
        // For example, if you added a getFirstName() method, you can use that.
        // return new Response('Well hi there '. $user->getEmail());
        return $this->render('user/profile.html.twig', [
            'user' => $user,
            // 'form2' => $form2->createView(),
        ]);
    }

    #[Route('/profile/edit/{id}', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, ManagerRegistry $doctrine, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $categories = $doctrine->getRepository(Categorie::class)->findAll();
        
        
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $picture */
            $picture = $form->get('picture')->getData();
            /** @var UploadedFile $passport */
            $passport = $form->get('passport')->getData();
            /** @var UploadedFile $cv */
            $cv = $form->get('cv')->getData();
            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();

            // this condition is needed because the 'picture' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$picture->guessExtension();
            
                // Move the file to the directory where brochures are stored
                try {
                    $picture->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setPicture($newFilename);
            }
            if($passport) {
                $originalFilename = pathinfo($passport->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$passport->guessExtension();
            
                // Move the file to the directory where brochures are stored
                try {
                    $passport->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setPassport($newFilename);
            }
            if($cv) {
                $originalFilename = pathinfo($cv->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$cv->guessExtension();
            
                // Move the file to the directory where brochures are stored
                try {
                    $cv->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setCv($newFilename);
            }
            if($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
            
                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setFile($newFilename);
            }
            
            if ($user->isComplete() == 100) {
                $user->setDisponibility(1);
            }
            $user->setUpdatedAt(new DateTime());
            
            $entityManager->flush();
            
            return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
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
