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
        // Get the session cookie as it persists across firewalls.
        $request = $event->getRequest();
        $cookieSession = $request->cookies->get("PHPSESSID");
        $previousRequest = $request->server->get('HTTP_REFERER');
        //Check if the user is logged in and if the URL does not contain 'admin and if the user come from backoffice
        if ($cookieSession && !str_contains($event->getRequest()->getPathInfo(), "admin") && str_contains($previousRequest, "admin")) {
            // Redirect the user to the logout page
            $url = $this->urlGeneratorInterface->generate('app_logout');
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
 