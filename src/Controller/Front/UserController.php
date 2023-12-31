<?php

namespace App\Controller\Front;


use App\Form\UserEmailType;
use App\Form\UserPasswordType;
use App\Repository\UserRepository;
use App\Service\FormVerificatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="app_user", methods={"GET", "POST"})
     */
    public function show(HttpFoundationRequest $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, FormVerificatorService $formVerificator): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        
        // Create the email update form
        $formEmail = $this->createForm(UserEmailType::class, $user);
        $formEmail->handleRequest($request);
        // Create the password update form
        $formPassword = $this->createForm(UserPasswordType::class, $user);
        $formPassword->handleRequest($request);

        // Handle the email update form
        if ($formEmail->isSubmitted()) {
            if($formEmail->isValid()) {

                $userRepository->add($user, true);
                $this->addFlash(
                    'success',
                    "La mise à jour a bien été effectuée."
                );
                return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);

            } else {
                $this->addFlash(
                    'danger',
                    "La mise à jour n'a pas pu être effectuée."
                );
            }
        }
       
        

        // Handle the password update form
        $formPassword = $this->createForm(UserPasswordType::class, $user);
        $formPassword->handleRequest($request);
        if ($formPassword->isSubmitted()) {
           
            if($formPassword->isValid()) {
                $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));

                $userRepository->add($user, true);

                $this->addFlash(
                    'success',
                    "Le mot de passe a bien été mis à jour"
                );

                return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
            } else {
                $this->addFlash(
                    'danger',
                    "Le mot de passe n'a pas pu être mis à jour"
                );
            }
        }

         // Render the user's profile page with email and password forms
        return $this->render('front/user/index.html.twig', [
            'formEmail' => $formEmail->createView(),
            'formPassword' => $formPassword->createView(),
        ]);
        
    }

    /**
     * @Route("/organigramme", name="app_organizational_chart")
     */
    public function showUsersWithPosition(UserRepository $userRepository): Response
    {

        $users = $userRepository->findAllWithPosition();

        return $this->render('front/user/show_positions.html.twig', [
            'users' => $users
        ]);
    }

}
