<?php
namespace Services;

use Models\Restaurant;
use Repositories\RestaurantRepository;

class RestaurantService {

    private $restaurantRepository;

    function __construct(RestaurantRepository $restaurantRepository)
    {
        $this->restaurantRepository = $restaurantRepository;
    }

    public function addRestaurant(Restaurant $restaurant): ?Restaurant {
        return $this->restaurantRepository->addRestaurant($restaurant);
    }

    public function getRestaurantById(int $id): ?Restaurant {
        return $this->restaurantRepository->getRestaurantById($id);
    }

    public function updateRestaurant(Restaurant $restaurant): ?Restaurant {
        return $this->restaurantRepository->updateRestaurant($restaurant);
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
}
