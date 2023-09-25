<?php

namespace App\Controller\Front;

use App\Service\SlideService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(SlideService $slideService): Response
    {
        $pictures = $slideService->getRandomPictures(5);

        return $this->render('front/main/index.html.twig', [
            "pictures" => $pictures
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
