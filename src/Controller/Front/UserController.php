<?php

namespace App\Controller\Front;


use App\Form\UserEmailType;
use App\Form\UserPasswordType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="app_user", methods={"GET", "POST"})
     */
    public function edit(HttpFoundationRequest $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        
        $formEmail = $this->createForm(UserEmailType::class, $user);
        $formEmail->handleRequest($request);
        if ($formEmail->isSubmitted() && $formEmail->isValid()) {
           
            $userRepository->add($user, true);

            $this->addFlash(
                'success',
                "La mise à jour a bien été effectuée."
                );

            return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
        }
        $formPassword = $this->createForm(UserPasswordType::class, $user);
        $formPassword->handleRequest($request);
        if ($formPassword->isSubmitted() && $formPassword->isValid()) {
           
            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
           
            $userRepository->add($user, true);

            $this->addFlash(
                'success',
                "Le mot de passe a bien été mis à jour"
                );

            return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
        }

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
