<?php

namespace App\Controller\Back;

use App\Entity\CourseType;
use App\Form\CourseTypeType;
use App\Repository\CourseTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin35786/cours-types")
 */
class CourseTypeController extends AbstractController
{
    /**
     * @Route("/", name="app_back_course_type_index", methods={"GET"})
     */
    public function index(CourseTypeRepository $courseTypeRepository): Response
    {
        return $this->render('back/course_type/index.html.twig', [
            'course_types' => $courseTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_back_course_type_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CourseTypeRepository $courseTypeRepository): Response
    {
        $courseType = new CourseType();
        $form = $this->createForm(CourseTypeType::class, $courseType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseTypeRepository->add($courseType, true);

            return $this->redirectToRoute('app_back_course_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/course_type/new.html.twig', [
            'course_type' => $courseType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_course_type_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CourseType $courseType, CourseTypeRepository $courseTypeRepository): Response
    {
        $form = $this->createForm(CourseTypeType::class, $courseType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseTypeRepository->add($courseType, true);

            return $this->redirectToRoute('app_back_course_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/course_type/edit.html.twig', [
            'course_type' => $courseType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_course_type_delete", methods={"POST"})
     */
    public function delete(Request $request, CourseType $courseType, CourseTypeRepository $courseTypeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$courseType->getId(), $request->request->get('_token'))) {
            $courseTypeRepository->remove($courseType, true);
        }

        return $this->redirectToRoute('app_back_course_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
