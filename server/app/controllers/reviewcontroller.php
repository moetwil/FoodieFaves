<?php

namespace Controllers;

use Exception;
use Services\{ReviewService, RestaurantService};

class ReviewController extends Controller
{
    private $service;
    private $restaurantService;

    // initialize services
    function __construct()
    {
        $this->service = new ReviewService();
        $this->restaurantService = new RestaurantService();
    }

    public function getById($id)
    {
        try {
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
            $limit = $_GET['limit'] ?? null;
            $offset = $_GET['offset'] ?? null;
            $order = $_GET['order'] ?? null;
            $filter = $_GET['filter'] ?? null;

            // $this->respond($filter);

            if($order=='asc' || $order == 'ASC'){
                $order = false;
            }else if($order == 'desc' || $order == 'DESC'){
                $order = true;
            }
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

    public function getByUser($id)
    {
        try {
            $reviews = $this->service->getReviewsByUser($id);

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
            $postedReview = $this->createObjectFromPostedJson("Models\\Review");

            $review = $this->service->createReview($postedReview);

            
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function update($id)
    {
        try {
            $review = $this->service->getReviewById($id);

            if($review == null) {
                $this->respondWithError(404, "Review not found");
                return;
            }

            $postedReview = $this->createObjectFromPostedJson("Models\\Review");
            $review = $this->service->updateReview($id, $postedReview);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($review);
    }

    public function delete($id)
    {
        try {
            $review = $this->service->getReviewById($id);

            if($review == null) {
                $this->respondWithError(404, "Review not found");
                return;
            }

            $response = $this->service->deleteReview($id);

            if ($response) {
                $this->respond("Review deleted");
            } else {
                $this->respondWithError(500, "Review could not be deleted");
            }

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function flag($id)
    {
        try {
            $this->authorizeAction($id);

            // flag the review
            $response = $this->service->flagReview($id);

            if ($response) {
                $this->respond("Review flagged");
            } else {
                $this->respondWithError(500, "Review could not be flagged");
            }

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }
    public function unflag($id)
    {
        try {
            $this->authorizeAction($id);

            // flag the review
            $response = $this->service->unflagReview($id);

            if ($response) {
                $this->respond("Review unflagged");
            } else {
                $this->respondWithError(500, "Review could not be flagged");
            }

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function approve($id)
    {
        try {
            $review = $this->service->getReviewById($id);

            if($review == null) {
                $this->respondWithError(404, "Review not found");
                return;
            }

            $response = $this->service->approveReview($id);

            if ($response) {
                $this->respond("Review approved");
            } else {
                $this->respondWithError(500, "Review could not be approved");
            }

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function getReviews(){
        try {
            $limit = $_GET['limit'] ?? null;
            $offset = $_GET['offset'] ?? null;
            $order = $_GET['order'] ?? null;
            $filter = $_GET['filter'] ?? null;

            // $this->respond($filter);

            if($order=='asc' || $order == 'ASC'){
                $order = false;
            }else if($order == 'desc' || $order == 'DESC'){
                $order = true;
            }

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

    private function authorizeAction($reviewId){
        // authorize
        $decoded = $this->checkForJwt();
        if($decoded == null) {
            $this->respondWithError(401, "Not authorized");
            return;
        }

        // get the review 
        $review = $this->service->getReviewById($reviewId);
        if($review == null) {
            $this->respondWithError(404, "Review not found");
            return;
        }

        // get the restaurant and check if the user is the owner
        $restaurant = $this->restaurantService->getRestaurantById($review->restaurant_id);
        if($restaurant->owner_id != $decoded->data->id) {
            $this->respondWithError(401, "You are not the owner of this restaurant");
            return;
        }

        return $review;
    }
}
