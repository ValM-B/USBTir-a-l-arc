<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class AdminLogoutSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event): void
    {
        // Get the session cookie as it persists across firewalls.
        $request = $event->getRequest();
        $cookieSession = $request->cookies->get("PHPSESSID");
        $previousRequest = $request->server->get('HTTP_REFERER');
        //Check if the user is logged in and if the URL does not contain 'admin' and if the user come from backoffice
        if ($cookieSession && !str_contains($event->getRequest()->getPathInfo(), "admin") && str_contains($previousRequest, "admin")) {
            // Redirect the user to the logout page
            $event->setResponse(new RedirectResponse("/deconnexion"));
        }
        dump($cookieSession);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
 