<?php

namespace Controllers;

use Exception;
use Services\RestaurantService;

class RestaurantController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new RestaurantService();
    }

    public function getById($id)
    {
        try {
            $restaurant = $this->service->getRestaurantById($id);

            if ($restaurant == null) {
                $this->respondWithError(404, "Restaurant not found");
                return;
            }

            $this->respond($restaurant);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function getAll()
    {
        try {
            $restaurants = $this->service->getAllRestaurants();

            if ($restaurants == null) {
                $this->respondWithError(404, "No restaurants found");
                return;
            }

            $this->respond($restaurants);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function getAllByOwner($id)
    {
        try {
            $restaurants = $this->service->getAllRestaurantsByOwner($id);

            if ($restaurants == null) {
                $this->respondWithError(404, "No restaurants found");
                return;
            }

            $this->respond($restaurants);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $postedRestaurant = $this->createObjectFromPostedJson("Models\\Restaurant");
            $restaurant = $this->service->addRestaurant($postedRestaurant);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($restaurant);
    }

    public function update($id)
    {
        try {

            $restaurant = $this->service->getRestaurantById($id);
            if($restaurant == null) {
                $this->respondWithError(404, "Restaurant not found");
                return;
            }

            $postedRestaurant = $this->createObjectFromPostedJson("Models\\Restaurant");
            $restaurant = $this->service->updateRestaurant($id, $postedRestaurant);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($restaurant);
    }

    public function delete($id)
    {
        try {
            $restaurant = $this->service->getRestaurantById($id);

            if($restaurant == null) {
                $this->respondWithError(404, "Restaurant not found");
                return;
            }

            $response = $this->service->deleteRestaurant($id);

            if($response == false) {
                $this->respondWithError(500, "Restaurant could not be deleted");
                return;
            }
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($response);
    }
}
