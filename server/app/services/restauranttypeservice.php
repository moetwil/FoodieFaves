<?php
namespace Services;

use Models\RestaurantType;
use Repositories\RestaurantTypeRepository;

class RestaurantTypeService {

    private $restaurantTypeRepository;

    function __construct()
    {
        $this->restaurantTypeRepository = new RestaurantTypeRepository();
    }

    public function getAllRestaurantTypes(): ?array {
        return $this->restaurantTypeRepository->getAllRestaurantTypes();
    }
}
