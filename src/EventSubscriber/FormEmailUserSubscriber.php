<?php

namespace App\EventSubscriber;

use App\Repository\UserRepository;
use App\Service\FormVerificatorService;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Security;

class FormEmailUserSubscriber implements EventSubscriberInterface
{
   
    private $security;
    private $userRepository;

    public function __construct( Security $security, UserRepository $userRepository)
    {
      
        $this->security = $security;
        $this->userRepository = $userRepository;

    }

    public function onKernelRequest(RequestEvent $event): void
    {
       
        $request = $event->getRequest();
        $route = $request->attributes->get('_route');
        if ($route === 'app_user' && $request->isMethod('POST')) {
            
            /**
             * @var \App\Entity\User
             */
            $user = $this->security->getUser();

            if($request->request->get('user_email')){
                $email = $request->request->get('user_email')['email'];
                
                //check if email is already used
                if ($this->userRepository->findOneBy(['email' => $email]) && $email !== $user->getEmail()) {

                   //add flash message
                    $request->getSession()->getFlashBag()->add('danger', 'L\'adresse email est déjà utilisée.');
                
                    $event->setResponse(new RedirectResponse("/profil"));
                }
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
