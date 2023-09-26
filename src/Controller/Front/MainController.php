<?php

namespace App\Controller\Front;

use App\Repository\UserRepository;
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
     * @Route("/nous-contacter", name="app_contact")
     */
    public function contact(UserRepository $repository): Response
    {
        $president = $repository->findPresidentPosition();
        
    return $this->render('front/main/contact.html.twig', [
        'controller_name' => 'MainController',
        'president' => $president   
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
