<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\User; // Assure-toi que l'entité User est importée

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'page_profilepage')]
    #[IsGranted('ROLE_USER')]
    public function index(ReservationRepository $reservationRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('No valid user instance found.');
        }

        $roles = $user->getRoles();

        if ($roles !== ['ROLE_USER']) {
            $this->addFlash('error', 'Access denied.');
            throw new AccessDeniedException('Access denied: This page is available only for exclusive ROLE_USER.');
        }

        $userId = $user->getId();

        $reservations = $reservationRepository->findReservationsByUserId($userId);

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'reservations' => $reservations,
        ]);
    }
}
