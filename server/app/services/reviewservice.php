<?php
namespace Services;

use Models\Review;
use Repositories\ReviewRepository;

class ReviewService {

    private $reviewRepository;

    function __construct()
    {
        $this->reviewRepository = new ReviewRepository();
    }

    public function createReview(Review $review)
    {
        return $this->reviewRepository->createReview($review);
    }

    public function getReviewById($id)
    {
        return $this->reviewRepository->getById($id);
    }

    public function getReviewsByRestaurant($restaurantId)
    {
        return $this->reviewRepository->getByRestaurant($restaurantId);
    }

    public function getReviewsByUser($userId)
    {
        return $this->reviewRepository->getByUser($userId);
    }

    public function getReviews($limit, $offset, $order){
        return $this->reviewRepository->getReviews($limit, $offset, $order);
    }

    public function updateReview($id, Review $review)
    {
        return $this->reviewRepository->updateReview($id, $review);
    }

    public function deleteReview($id)
    {
        return $this->reviewRepository->deleteReview($id);
    }

    public function flagReview($id)
    {
        return $this->reviewRepository->flagReview($id, true);
    }
    public function unflagReview($id)
    {
        return $this->reviewRepository->flagReview($id, false);
    }

    public function approveReview($id)
    {
        return $this->reviewRepository->approveReview($id);
    }

    

}
