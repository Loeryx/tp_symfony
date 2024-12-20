<?php

namespace App\Controller;

use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', 'page_homepage')]
    public function home(RestaurantRepository $restaurantsRepository): Response
    {
        $restaurants = $restaurantsRepository->findPopular(6);
        return $this->render('home.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }

    #[Route('/restaurant/{id}', 'page_restaurant')]
    public function show(RestaurantRepository $restaurantRepository, int $id): Response
    {
        $restaurant = $restaurantRepository->find($id);

        if (!$restaurant) {
            throw $this->createNotFoundException('Restaurant not found');
        }

        return $this->render('restaurant/restaurantInfo.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }

    #[Route('/banned', name: 'page_bannedpage')]
    public function banned(): Response
    {
        return $this->render('banned.html.twig', [
            'message' => 'You are banned from this platform. Please contact support if you think this is a mistake.',
        ]);
    }
}