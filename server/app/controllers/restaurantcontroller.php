<?php

namespace Controllers;

use Exception;
use Services\{RestaurantService, UserService};

class RestaurantController extends Controller
{
    private $service;
    private $userService;

    // initialize services
    function __construct()
    {
        $this->service = new RestaurantService();
        $this->userService = new UserService();
    }

    public function getById($id)
    {
        try {
            // get restaurant by id from the database and check if it is found
            $restaurant = $this->service->getRestaurantById($id);
            if (!$restaurant) {
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
            // get information from the query string
            $limit = $_GET['limit'] ?? null;
            $offset = $_GET['offset'] ?? null;
            $order = $_GET['order'] ?? null;
            $filter = $_GET['filter'] ?? null;
            $type = $_GET['type'] ?? null;
            
            // check if the order is valid
            if($order=='asc' || $order == 'ASC'){
                $order = false;
            }else if($order == 'desc' || $order == 'DESC'){
                $order = true;
            }

            // get all restaurants and check if any are found
            $restaurants = $this->service->getAllRestaurants($limit, $offset, $order, $filter, $type);
            if (!$restaurants) {
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
            // get restaurants by owner id and check if any are found
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
            // verify jwt
            $decoded = $this->checkForJwt();
            if(!$decoded){
                $this->respondWithError(401, "You are not authorized");
                return;
            }

            // check if the user is of type owner
            $userId = $decoded->data->id;
            $user = $this->userService->getUserById($userId);
            if($user->user_type != 1){
                $this->respondWithError(401, "You are not authorized to create a restaurant");
                return;
            }
            
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
            // check if user is owner of restaurant
            if(!$this->authorizeOwnerAction($id))return;

            // update restaurant
            $postedRestaurant = $this->createObjectFromPostedJson("Models\\Restaurant");
            $restaurant = $this->service->updateRestaurant($id, $postedRestaurant);
            $this->respond($restaurant);    
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            // verify jwt and check if the user is the owner of the restaurant
            if(!$this->authorizeOwnerAction($id))return;

            // delete restaurant
            $response = $this->service->deleteRestaurant($id);
            if(!$response) {
                $this->respondWithError(500, "Restaurant could not be deleted");
                return;
            }
            $this->respond($id);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function getRestaurantReviewsAmount($id)
    {
        try {
            // get restaurant by id from the database and check if it is found
            $restaurant = $this->service->getRestaurantById($id);
            if($restaurant == null) {
                $this->respondWithError(404, "Restaurant not found");
                return;
            }

            // get amount of reviews
            $amount = $this->service->getRestaurantReviewsAmount($id);
            $this->respond($amount);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function getRestaurantRating($id){
        try {
            // get restaurant by id from the database and check if it is found
            $restaurant = $this->service->getRestaurantById($id);
            if($restaurant == null) {
                $this->respondWithError(404, "Restaurant not found");
                return;
            }

            // get rating
            $rating = $this->service->getRestaurantRating($id);
            $this->respond($rating);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function search($query){
        try {
            $restaurants = $this->service->search($query);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
        $this->respond($restaurants);
    }

    private function authorizeOwnerAction($restaurantId){
        // authorize
        $decoded = $this->checkForJwt();
        if(!$decoded) {
            $this->respondWithError(401, "Not authorized");
            return false;
        }
        
        // check if the user is of type owner
        $userId = $decoded->data->id;
        $user = $this->userService->getUserById($userId);
        if($user->user_type != 1){
            $this->respondWithError(401, "You are not a restaurant owner");
            return false;
        }
        
        // get the restaurant and check if the user is the owner
        $restaurant = $this->service->getRestaurantById($restaurantId);
        if($restaurant == null) {
            $this->respondWithError(404, "Restaurant not found");
            return false;
        }

        if($restaurant->owner_id != $userId) {
            $this->respondWithError(401, "You are not the owner of this restaurant");
            return false;
        }
        
        return true;
    }


}
