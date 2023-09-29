<?php

namespace App\EventSubscriber;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

class LoginSubscriber implements EventSubscriberInterface
{
    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request;
    }

    public function onSecurityAuthenticationSuccess(AuthenticationSuccessEvent $event, $request): void
    {
        $role = $event->getAuthenticationToken()->getUser()->getRoles();
        if ($this->request->getCurrentRequest()->getPathInfo() === "/connexion" && in_array("ROLE_ADMIN", $role)) {
            // Si l'utilisateur est administrateur, renvoyez une réponse d'erreur.
            // isGranted('ROLE_ADMIN'))
            throw new AccessDeniedHttpException('Accès refusé');
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'security.authentication.success' => 'onSecurityAuthenticationSuccess',
        ];
    }
}
