<?php

namespace App\Controller\Front;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TarifRepository;
use App\Service\CoursesListService;

class TarifController extends AbstractController
{
    /**
     * @Route("/horaires-et-tarifs", name="app_tarif_and_timetable")
     */
    public function viewTarifsAndTimetable(TarifRepository $tarifRepository, CoursesListService $coursesListService): Response
    {
        $tarifs = $tarifRepository->findAll();
        $coursesList = $coursesListService->coursesListByDay();
        
        return $this->render('/front/horaireTarif/horaire_tarifs.html.twig', [
            'controller_name' => 'TarifController',
            'tarifs' => $tarifs,
            'courses' => $coursesList
        ]);
    }
}
