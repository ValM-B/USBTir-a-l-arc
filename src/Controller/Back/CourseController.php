<?php

namespace App\Controller\Back;

use App\Entity\Course;
use App\Form\CourseFormType;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin35786/cours")
 */
class CourseController extends AbstractController
{
    /**
     * @Route("/", name="app_back_course_index", methods={"GET"})
     */
    public function index(CourseRepository $courseRepository): Response
    {
        return $this->render('back/course/index.html.twig', [
            'courses' => $courseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_back_course_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CourseRepository $courseRepository): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseFormType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseRepository->add($course, true);

            return $this->redirectToRoute('app_back_course_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/course/new.html.twig', [
            'course' => $course,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_course_show", methods={"GET"})
     */
    public function show(Course $course): Response
    {
        return $this->render('back/course/show.html.twig', [
            'course' => $course,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_course_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Course $course, CourseRepository $courseRepository): Response
    {
        $form = $this->createForm(CourseFormType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseRepository->add($course, true);

            return $this->redirectToRoute('app_back_course_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/course/edit.html.twig', [
            'course' => $course,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_course_delete", methods={"POST"})
     */
    public function delete(Request $request, Course $course, CourseRepository $courseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$course->getId(), $request->request->get('_token'))) {
            $courseRepository->remove($course, true);
        }

        return $this->redirectToRoute('app_back_course_index', [], Response::HTTP_SEE_OTHER);
    }
}
