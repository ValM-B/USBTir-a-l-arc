<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TarifRepository;
use App\Repository\HoraireRepository;

class TarifController extends AbstractController
{
    /**
     * @Route("/nous-contacter", name="app_tarif_and_timetable")
     */
    public function viewTarifsAndTimetable(TarifRepository $tarifRepository): Response
    {
        $tarifs = $tarifRepository->findAll();

        return $this->render('/front/tarif_and_timetable/index.html.twig', [
            'controller_name' => 'TarifController',
            'tarifs' => $tarifs,
        ]);
    }
}
