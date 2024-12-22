<?php

namespace App\Controller;

use App\Enum\RestaurantCategoryEnum;
use App\Repository\RestaurantRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', 'page_homepage')]
    public function home(RestaurantRepository $restaurantsRepository, Request $request): Response
    {
        $selectedCategory = $request->query->get('category');

        if ($selectedCategory) {
            $restaurants = $restaurantsRepository->findByCategory($selectedCategory);
        } else {
            $restaurants = $restaurantsRepository->findPopular(6);
        }

        $usedCategories = $restaurantsRepository->findCategoriesWithRestaurants();

        $availableCategories = array_filter(
            RestaurantCategoryEnum::cases(),
            fn($category) => in_array($category->value, $usedCategories)
        );

        return $this->render('home.html.twig', [
            'restaurants' => $restaurants,
            'availableCategories' => $availableCategories,
            'selectedCategory' => $selectedCategory,
        ]);
    }


    #[Route('/restaurant/{id}', name: 'page_restaurant')]
    public function showRestaurant(RestaurantRepository $restaurantRepository, int $id): Response
    {
        $restaurant = $restaurantRepository->find($id);

        if (!$restaurant) {
            throw $this->createNotFoundException('Restaurant not found');
        }

        return $this->render('restaurant/restaurantInfo.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }

    #[Route('/banned', 'page_bannedpage')]
    public function banned(): Response
    {
        return $this->render('admin/banned.html.twig', [
            'message' => 'You are banned from this platform. Please contact support if you think this is a mistake.',
        ]);
    }

    #[Route('/admin', 'page_adminpage')]
    public function admin(): Response
    {
        return $this->render('admin/admin.html.twig', [
            'message' => 'You are banned from this platform. Please contact support if you think this is a mistake.',
        ]);
    }
}