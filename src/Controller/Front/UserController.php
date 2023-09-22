<?php

namespace App\Controller\Front;

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
}
