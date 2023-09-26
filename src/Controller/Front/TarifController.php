<?php

namespace App\Controller\Front;

use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TarifRepository;


class TarifController extends AbstractController
{
    /**
     * @Route("/horaires-et-tarifs", name="app_tarif_and_timetable")
     */
    public function viewTarifsAndTimetable(TarifRepository $tarifRepository, CourseRepository $courseRepository): Response
    {
        $tarifs = $tarifRepository->findAll();
        $courses = $courseRepository->findAll();

        return $this->render('/front/horaireTarif/horaire_tarifs.html.twig', [
            'controller_name' => 'TarifController',
            'tarifs' => $tarifs,
            'courses' => $courses
        ]);
    }
}
