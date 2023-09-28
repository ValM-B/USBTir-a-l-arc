<?php

namespace App\Controller\Back;

use App\Entity\Tarif;
use App\Form\TarifType;
use App\Repository\TarifRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin35786/tarifs")
 */
class TarifController extends AbstractController
{
    /**
     * @Route("/", name="app_back_tarif_index", methods={"GET"})
     */
    public function index(TarifRepository $tarifRepository): Response
    {
        return $this->render('back/tarif/index.html.twig', [
            'tarifs' => $tarifRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_back_tarif_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TarifRepository $tarifRepository): Response
    {
        $tarif = new Tarif();
        $form = $this->createForm(TarifType::class, $tarif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tarifRepository->add($tarif, true);

            return $this->redirectToRoute('app_back_tarif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/tarif/new.html.twig', [
            'tarif' => $tarif,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_tarif_show", methods={"GET"})
     */
    public function show(Tarif $tarif): Response
    {
        return $this->render('back/tarif/show.html.twig', [
            'tarif' => $tarif,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_tarif_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Tarif $tarif, TarifRepository $tarifRepository): Response
    {
        $form = $this->createForm(TarifType::class, $tarif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tarifRepository->add($tarif, true);

            return $this->redirectToRoute('app_back_tarif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/tarif/edit.html.twig', [
            'tarif' => $tarif,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_tarif_delete", methods={"POST"})
     */
    public function delete(Request $request, Tarif $tarif, TarifRepository $tarifRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tarif->getId(), $request->request->get('_token'))) {
            $tarifRepository->remove($tarif, true);
        }

        return $this->redirectToRoute('app_back_tarif_index', [], Response::HTTP_SEE_OTHER);
    }
}
