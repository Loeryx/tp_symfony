<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SecurityEventListener
{
    private TokenStorageInterface $tokenStorage;
    private RouterInterface $router;

    public function __construct(TokenStorageInterface $tokenStorage, RouterInterface $router)
    {
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $token = $this->tokenStorage->getToken();

        // Si aucun utilisateur connecté, sortir
        if (!$token || !$token->getUser()) {
            return;
        }

        $user = $token->getUser();

        // Si l'utilisateur est banni
        if (in_array('ROLE_BANNED', $user->getRoles(), true)) {
            // Ne pas rediriger si l'utilisateur est déjà sur la page bannie
            if ($request->get('_route') === 'page_bannedpage') {
                return;
            }

            // Rediriger vers la page bannie
            $event->setResponse(new RedirectResponse($this->router->generate('page_bannedpage')));
        }
    }
}
