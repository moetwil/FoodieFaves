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
        // $this->respond($id);
        try {
            $newId = (int)$id;
            $restaurants = $this->service->getAllRestaurantsByOwner($newId);

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
            $decoded = $this->checkForJwt();
            
            $userId = $decoded->data->id;
            $postedRestaurant = $this->createObjectFromPostedJson("Models\\Restaurant");
            $restaurant = $this->service->addRestaurant($postedRestaurant, $userId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
        $this->respond($restaurant);
    }

    public function update($id)
    {
        try {
            $this->checkForJwt();

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

            $decoded = $this->checkForJwt();

            $restaurant = $this->service->getRestaurantById($id);

            if($restaurant == null) {
                $this->respondWithError(404, "Restaurant not found");
                return;
            }

            $ownerId = $restaurant->owner_id;

            // check if user is owner of restaurant
            if($restaurant->owner_id != $decoded->data->id) {
                $this->respondWithError(401, "You are not authorized to delete this restaurant");
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

        // $this->respond($response);
    }

    public function getRestaurantReviewsAmount($id)
    {
        try {
            $restaurant = $this->service->getRestaurantById($id);

            if($restaurant == null) {
                $this->respondWithError(404, "Restaurant not found");
                return;
            }

            $amount = $this->service->getRestaurantReviewsAmount($id);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($amount);
    }

    public function getRestaurantRating($id){
        try {
            $restaurant = $this->service->getRestaurantById($id);

            if($restaurant == null) {
                $this->respondWithError(404, "Restaurant not found");
                return;
            }

            $rating = $this->service->getRestaurantRating($id);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($rating);
    }

    public function search($query){
        try {
            $restaurants = $this->service->search($query);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($restaurants);
    }


}
