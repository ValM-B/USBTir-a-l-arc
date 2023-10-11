<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AdminLogoutSubscriber implements EventSubscriberInterface
{
    private $tokenStorage;
    private $urlGeneratorInterface;

    public function __construct(TokenStorageInterface $tokenStorage, UrlGeneratorInterface $urlGeneratorInterface)
    {
        $this->tokenStorage = $tokenStorage;
        $this->urlGeneratorInterface = $urlGeneratorInterface;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $user = null;
        if ($this->tokenStorage->getToken()) {
            $user = $this->tokenStorage->getToken()->getUser();
        }
        //Check if the user is logged in and if the URL does not contain 'admin
        if ($user && !strpos($event->getRequest()->getPathInfo(), "admin")) {
            // If the URL does not contain 'admin', log out the user
            $this->tokenStorage->setToken(null);
            // Redirect the user to the logout page
            $url = $this->urlGeneratorInterface->generate('app_logout');
            dd($url);
            $response = new RedirectResponse($url);
            $event->setResponse($response);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
