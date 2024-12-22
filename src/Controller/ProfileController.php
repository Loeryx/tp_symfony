<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\User; // Assure-toi que l'entité User est importée

#[Route('/profile')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'page_profilepage')]
    public function index(ReservationRepository $reservationRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('No valid user instance found.');
        }

        $userId = $user->getId(); // Warning corrigé

        $reservations = $reservationRepository->findReservationsByUserId($userId);

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'reservations' => $reservations,
        ]);
    }
}
