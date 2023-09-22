<?php

namespace App\Controller\Front;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="app_user")
     */
    public function index(): Response
    {
        return $this->render('front/user/index.html.twig', [
            
        ]);
    }

    /**
     * @Route("/organigramme", name="app_organization_chart")
     */
    public function showUsersWithPosition(UserRepository $userRepository): Response
    {

        $users = $userRepository->findAllWithPosition();

        return $this->render('front/user/show_positions.html.twig', [
            'users' => $users
        ]);
    }
}
