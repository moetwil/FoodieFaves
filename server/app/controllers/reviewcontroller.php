<?php

namespace Controllers;

use Exception;
use Services\ReviewService;

class ReviewController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new ReviewService();
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
            $reviews = $this->service->getReviewsByRestaurant($id);

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
            $review = $this->service->getReviewById($id);

            if($review == null) {
                $this->respondWithError(404, "Review not found");
                return;
            }

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
}
