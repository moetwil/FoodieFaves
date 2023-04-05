<?php
namespace Controllers;

use Exception;
use Services\{ReviewService, RestaurantService, UserService};

class ReviewController extends Controller
{
    private $service;
    private $restaurantService;
    private $userService;

    // initialize services
    function __construct()
    {
        $this->service = new ReviewService();
        $this->restaurantService = new RestaurantService();
        $this->userService = new UserService();

    }

    public function getById($id)
    {
        try {
            // get review by id from the database and check if it is found
            $review = $this->service->getReviewById($id);
            if ($review == null) {
                $this->respondWithError(404, "Review not found");
                return;
            }

            $this->respond($review);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function getByRestaurant($id)
    {
        try {
            // get information from the query string
            $limit = $_GET['limit'] ?? null;
            $offset = $_GET['offset'] ?? null;
            $order = $_GET['order'] ?? null;
            $filter = $_GET['filter'] ?? null;

            // check if the order is valid
            if($order=='asc' || $order == 'ASC'){
                $order = false;
            }else if($order == 'desc' || $order == 'DESC'){
                $order = true;
            }
            // get reviews by restaurant id from the database and check if it is found
            $reviews = $this->service->getReviewsByRestaurant($id, $limit, $offset, $order, $filter);
            if ($reviews == null) {
                $this->respondWithError(404, "Reviews not found");
                return;
            }

            $this->respond($reviews);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function create()
    {
        try {
            // check for JWT
            if(!$this->checkForJWT()) return;

            // create review from posted data and add to database
            $postedReview = $this->createObjectFromPostedJson("Models\\Review");
            $review = $this->service->createReview($postedReview);

            $this->respond($review);            
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    
    public function delete($id)
    {
        try {
            // check if the user is an admin
            if(!$this->authorizeAdmin()) return;

            // get review by id from the database and check if it is found
            $review = $this->service->getReviewById($id);
            if($review == null) {
                $this->respondWithError(404, "Review not found");
                return;
            }
            
            // delete the review 
            $response = $this->service->deleteReview($id);
            
            if ($response) {
                $this->respond("Review: $id deleted");
            } else {
                $this->respondWithError(500, "Review: $id could not be deleted");
            }
            
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }
    
    public function flag($id)
    {
        try {
            // check if the user is the restaurant owner
            if(!$this->authorizeOwnerAction($id)) return;
            
            // flag the review
            $response = $this->service->flagReview($id);
            
            // send response
            if ($response) {
                $this->respond("Review: $id flagged");
            } else {
                $this->respondWithError(500, "Review: $id could not be flagged");
            }
            
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }
    public function unflag($id)
    {
        try {
            // check if the user is the restaurant owner
            if(!$this->authorizeOwnerAction($id)) return;
            
            // unflag the review
            $response = $this->service->unflagReview($id);
            
            // send response
            if ($response) {
                $this->respond("Review: $id unflagged");
            } else {
                $this->respondWithError(500, "Review: $id could not be flagged");
            }
            
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }
    
    public function approve($id)
    {
        try {
            // check if the user an admin
            if(!$this->authorizeAdmin()) return;

            $review = $this->service->getReviewById($id);
            
            // check if the review is found
            if($review == null) {
                $this->respondWithError(404, "Review: $id not found");
                return;
            }
            
            $response = $this->service->approveReview($id);
            
            // send response
            if ($response) {
                $this->respond("Review: $id approved");
            } else {
                $this->respondWithError(500, "Review: $id could not be approved");
            }
            
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }
    
    public function getReviews(){
        try {
            // get information from the query string
            $limit = $_GET['limit'] ?? null;
            $offset = $_GET['offset'] ?? null;
            $order = $_GET['order'] ?? null;
            $filter = $_GET['filter'] ?? null;
            
            // check if the order is valid
            if($order=='asc' || $order == 'ASC'){
                $order = false;
            }else if($order == 'desc' || $order == 'DESC'){
                $order = true;
            }
            
            // get reviews from the database and check if it is found
            $reviews = $this->service->getReviews($limit, $offset, $order, $filter);
            if ($reviews == null) {
                $this->respondWithError(404, "Reviews not found");
                return;
            }
            
            $this->respond($reviews);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }
    
    private function authorizeOwnerAction($reviewId){
        // authorize
        $decoded = $this->checkForJwt();
        if(!$decoded) {
            $this->respondWithError(401, "Not authorized");
            return false;
        }
        
        // get the review 
        $review = $this->service->getReviewById($reviewId);
        if($review == null) {
            $this->respondWithError(404, "Review not found");
            return false;
        }
        
        // get the restaurant and check if the user is the owner
        $restaurant = $this->restaurantService->getRestaurantById($review->restaurant_id);
        if($restaurant->owner_id != $decoded->data->id) {
            $this->respondWithError(401, "You are not the owner of this restaurant");
            return false;
        }
        
        return true;
    }

    private function authorizeAdmin(){
        // authorize
        $decoded = $this->checkForJwt();
        if(!$decoded) {
            $this->respondWithError(401, "Not authorized");
            return false;
        }
        
        // get the user and check if the user is admin
        $user = $this->userService->getUserById($decoded->data->id);
        if(!$user->is_admin) {
            $this->respondWithError(401, "You are not an admin");
            return false;
        }
        
        return true;
    }
}
