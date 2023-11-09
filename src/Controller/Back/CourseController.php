<?php

namespace App\Controller\Back;

use App\Entity\Course;
use App\Form\CourseFormType;
use App\Repository\CourseRepository;
use App\Service\MailerService;
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
            $this->addFlash(
				'success',
				"Le cours a bien été créé"
			);

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
            $this->addFlash(
            'success',
            "Le cours a bien été modifié."
            );
    
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
            $this->addFlash(
				'success',
				"Le cours a bien été supprimé"
			);
        } else {
            $this->addFlash(
				'danger',
				"Une erreur s'est produite, le cours n'a pas été supprimé"
			);
        }

        return $this->redirectToRoute('app_back_course_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/email", name="app_back_course_email")
     */
    public function email(Course $course)
    {
        return $this->render('back/course/mail_form.html.twig', [
            'course' => $course,
        ]);
    }

     /**
     * @Route("/{id}/send-email", name="app_back_course_email_send", methods={"POST"})
     */
    public function sendEmail(Course $course, Request $request, MailerService $mailer)
    {
        $object = $request->request->get('object');
        $title = $request->request->get('title');
        
        
        $users = $course->getUsers();
       
        foreach ($users as $user) {
            $content = $request->request->get('content');
            $content = str_replace("[prénom]", $user->getFirstname(), $content);
            $content = str_replace("[nom]", $user->getLastname(), $content);
            $mailer->sendToUser(
                $user->getEmail(),
                $object,
                "email/user_mail.html.twig",
                [ 'title' => $title,
                'content' => $content,]
               );
        }
        
        $this->addFlash(
            'success',
            "L'email a bien été envoyé"
        );

        return $this->redirectToRoute('app_back_course_show', ["id" => $course->getId()], Response::HTTP_SEE_OTHER);
    }
}
