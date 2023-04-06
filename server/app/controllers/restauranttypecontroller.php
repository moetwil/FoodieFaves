<?php

namespace Controllers;

use Exception;
use Services\RestaurantTypeService;

class RestaurantTypeController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new RestaurantTypeService();
    }

    

    public function getAll()
    {
        try {
            $restaurantTypes = $this->service->getAllRestaurantTypes();

            // check if any restaurant types are found
            if ($restaurantTypes == null) {
                $this->respondWithError(404, "No restaurants types found");
                return;
            }

            $this->respond($restaurantTypes);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }
}
