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

        if (!$token || !$token->getUser()) {
            return;
        }

        $user = $token->getUser();

        if (in_array('ROLE_BANNED', $user->getRoles(), true)) {
            if ($request->get('_route') === 'page_bannedpage') {
                return;
            }
            $event->setResponse(new RedirectResponse($this->router->generate('page_bannedpage')));
        }
    }
}
