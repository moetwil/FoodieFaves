<?php
namespace Services;

use Models\{Restaurant, User};
use Repositories\RestaurantRepository;

class RestaurantService {

    private $restaurantRepository;

    function __construct()
    {
        $this->restaurantRepository = new RestaurantRepository();
    }

    public function addRestaurant(Restaurant $restaurant, $userId): ?Restaurant {
        return $this->restaurantRepository->createRestaurant($restaurant, $userId);
    }

    public function getRestaurantById($id) {
        return $this->restaurantRepository->getRestaurantById($id);
    }

    public function updateRestaurant($id, Restaurant $restaurant): ?Restaurant {
        return $this->restaurantRepository->updateRestaurant($id, $restaurant);
    }

    public function deleteRestaurant(int $id): bool {
        return $this->restaurantRepository->deleteRestaurant($id);
    }

    public function getAllRestaurants(): ?array {
        return $this->restaurantRepository->getAllRestaurants();
    }

    public function getAllRestaurantsByOwner(int $ownerId): ?array {
        return $this->restaurantRepository->getAllRestaurantsByOwner($ownerId);
    }

    public function getRestaurantReviewsAmount($id){
        return $this->restaurantRepository->getRestaurantReviewsAmount($id);
    }

    public function getRestaurantRating($id){
        return $this->restaurantRepository->getRestaurantRating($id);
    }

    public function search($query){
        return $this->restaurantRepository->search($query);
    }
}
