<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class AdminLogoutSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMainRequest()) {
            // don't do anything if it's not the main request
            return;
        }
        $request = $event->getRequest();
        // Get the session cookie as it persists across firewalls.
        $cookieSession = $request->cookies->get("PHPSESSID");
        $previousRequest = $request->server->get('HTTP_REFERER');
        //Check if the user is logged in and if the URL does not contain 'admin' and if the user come from backoffice
        var_dump($event->getRequest()->getPathInfo());
        dump($event->getRequest()->getPathInfo());
        if ($cookieSession && !str_contains($event->getRequest()->getPathInfo(), "admin") && str_contains($previousRequest, "admin")) {
            // Redirect the user to the logout page
            $event->setResponse(new RedirectResponse("/deconnexion"));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
 