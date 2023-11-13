<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\FormVerificatorService;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

/**
 * @Route("/admin35786/utilisateurs")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="app_back_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('back/user/index.html.twig');
    }


    /**
     * @Route("/new", name="app_back_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, MailerService $mailer, FormVerificatorService $formVerificator): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($formVerificator->checkEmail($user)) {
                $this->addFlash(
                    'danger',
                    "Un utilisateur avec cette adresse email existe déjà."
                );
                return $this->renderForm('back/user/new.html.twig', [
                    'user' => $user,
                    'form' => $form,
                ]);
            } elseif ($formVerificator->checkLicenceNumber($user)) {
                $this->addFlash(
                    'danger',
                    "Un utilisateur avec ce numéro de licence existe déjà."
                );
                return $this->renderForm('back/user/new.html.twig', [
                    'user' => $user,
                    'form' => $form,
                ]);
            }  elseif ($form->isSubmitted() && !$form->isValid()) {
                $this->addFlash(
                    'danger',
                    "Une erreur s'est produite, le licencié n'a pas été ajouté."
                    );
                    return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_BAD_REQUEST);
            }

            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
            $userRepository->add($user, true);

            $mailer->sendToUser(
                $user->getEmail(),
                "Nouvel espace privé",
                "email/user_created.html.twig",
                ['user' => $user]
            );

            $this->addFlash(
                'success',
                "Le licencié a bien été ajouté."
                );

            return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_SEE_OTHER);
        }   

        return $this->renderForm('back/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('back/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository, FormVerificatorService $formVerificator): Response
    {
        $form = $this->createForm(UserType::class, $user, ["custom_option" => "edit"]);
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) {

            $userByLicence = $userRepository->findOneBy(['licenceNumber' => $user->getLicenceNumber()]); //Find user who has the same licence number

            //if the user who has the same email is not the same as the user who is edited
            if($formVerificator->checkEmail($user)) {
               
                $this->addFlash(
                    'danger',
                    "Un utilisateur avec cette adresse email existe déjà."
                );
                return $this->renderForm('back/user/edit.html.twig', [
                    'user' => $user,
                    'form' => $form,
                ]);

            //if the user who has the same licence number is not the same as the user who is edited
            } elseif ($formVerificator->checkLicenceNumber($user)) {
                $this->addFlash(
                    'danger',
                    "Un utilisateur avec ce numéro de licence existe déjà."
                );
                return $this->renderForm('back/user/edit.html.twig', [
                    'user' => $user,
                    'form' => $form,
                ]);

            }  elseif ($form->isSubmitted() && !$form->isValid()) {
                $this->addFlash(
                    'danger',
                    "Une erreur s'est produite, le licencié n'a pas été modifié."
                    );
                    return $this->redirectToRoute('app_back_user_show', ['id' => $user->getId()], Response::HTTP_BAD_REQUEST);
            }

            $userRepository->add($user, true);

            $this->addFlash(
                'success',
                "Le licencié a bien été modifié."
                );

            return $this->redirectToRoute('app_back_user_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
            $this->addFlash(
                'success',
                "Le licencié a bien été supprimé."
                );
        } else {
            $this->addFlash(
                'danger',
                "Une erreur s'est produite, le licencié n'a pas été supprimé."
                );
        }

        return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_SEE_OTHER);
    }

     /**
     * @Route("/{id}/mail", name="app_back_user_mail", methods={"GET"})
     */
    public function mail(User $user, MailerService $mailer): Response
    {
        $mailer->sendToUser(
            $user->getEmail(),
            "Message de USB Tir à l'arc",
            "email/user_mail.html.twig",
            []
           );

        return $this->render('back/user/show.html.twig', [
            'user' => $user,
        ]);
    }
}
