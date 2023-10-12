<?php

namespace App\EventSubscriber;

use App\Service\EnvironnmentService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class AdminLogoutSubscriber implements EventSubscriberInterface
{
    private $environnmentService;

    public function __construct(EnvironnmentService $environnmentService)
    {
        $this->environnmentService = $environnmentService;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $environnment = $this->environnmentService->getEnvironnment();
        if ($environnment === "dev") {
            // don't do anything if it's dev env because it's bug Symfony
            return;
        }
        $request = $event->getRequest();
        // Get the session cookie as it persists across firewalls.
        $cookieSession = $request->cookies->get("PHPSESSID");
        $previousRequest = $request->server->get('HTTP_REFERER');
        //Check if the user is logged in and if the URL does not contain 'admin' and if the user come from backoffice
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
 