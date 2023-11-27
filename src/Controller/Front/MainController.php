<?php

namespace App\Controller\Front;

use App\Repository\CourseRepository;
use App\Repository\TarifRepository;
use App\Service\SlideService;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(UserRepository $userRepository, TarifRepository $tarifRepository, CourseRepository $courseRepository): Response
    {
        $president = $userRepository->findPresidentPosition();
        $tarifs = $tarifRepository->findAll();
        $courses = $courseRepository->findAllOrderByDay();


        return $this->render('front/main/index.html.twig', [
            'president' => $president,
            'tarifs' => $tarifs,
            'courses' => $courses
        ]);
    }
    
     /**
     * @Route("/mentions-legales", name="app_legal_notice")
     */
    public function legalNotice():Response
    {
        return $this->render('front/main/legal_notice.html.twig', [

        ]); 
    }
}
