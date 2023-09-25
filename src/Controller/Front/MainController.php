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
     * @Route("/nous-contacter", name="app_access")
     */
    public function access(): Response
    {
        $sections = [
            [
                'text' => 'Text for Section 1',
                'image' => 'image1.jpg',
            ],
            [
                'text' => 'Text for Section 2',
                'image' => 'image2.jpg',
            ],
            [
                'text' => 'Text for Section 3',
                'image' => 'image3.jpg',
            ],
        ];

        $indoorMapUrl = 'https://www.google.fr/maps/place/Complexe+Sportif+Jehan+Buhan/@44.8666217,-0.5863453,17z/data=!4m6!3m5!1s0xd5529f7a0a66e5b:0x240f9bf94f019815!8m2!3d44.8666331!4d-0.5865706!16s%2Fg%2F11p1028xwj?entry=ttu';
        $outdoorMapUrl = 'https://www.google.fr/maps/place/Pas+de+tir+ext%C3%A9rieur+Godard/@44.8682844,-0.5876472,17z/data=!4m14!1m7!3m6!1s0xd552926f6ffd60f:0x4cc99c15e8214ee5!2sPas+de+tir+ext%C3%A9rieur+Godard!8m2!3d44.8682806!4d-0.5850723!16s%2Fg%2F11f6g4yv8r!3m5!1s0xd552926f6ffd60f:0x4cc99c15e8214ee5!8m2!3d44.8682806!4d-0.5850723!16s%2Fg%2F11f6g4yv8r?entry=ttu';

        return $this->render('front/access.html.twig', [
            'controller_name' => 'MainController',
            'sections' => $sections,
            'indoor_map_url' => $indoorMapUrl,
            'outdoor_map_url' => $outdoorMapUrl,
        ]);
    }
    /**
     * @Route("/nous-contacter", name="app_contact")
     */
    public function contact(): Response
    {
        return $this->render('front/contact/contact.html.twig',[
            'controller_name' => 'MainController',
        ]);
    }
}
