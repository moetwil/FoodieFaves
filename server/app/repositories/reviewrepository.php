<?php
namespace Repositories;

use PDO;
use PDOException;
use Models\Review;

class ReviewRepository extends Repository
{
    public function getById($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM Review WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Review');
            $review = $stmt->fetch();

            return $review;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getByRestaurant($restaurantId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM Review WHERE restaurant_id = :restaurant_id");
            $stmt->bindParam(':restaurant_id', $restaurantId);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Review');
            $reviews = $stmt->fetchAll();

            return $reviews;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getLastThree(){
        try {
            $stmt = $this->connection->prepare("SELECT * FROM Review ORDER BY id DESC LIMIT 3");
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Review');
            $reviews = $stmt->fetchAll();

            return $reviews;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getByUser($userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM Review WHERE user_id = :userId");
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Review');
            $reviews = $stmt->fetchAll();

            return $reviews;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function createReview(Review $review) 
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO Review (food_rating, service_rating, price_value_rating, review_text, restaurant_id, user_id, image, flagged, approved) VALUES (:food_rating, :service_rating, :price_value_rating, :review_text, :restaurant_id, :user_id, :image, :flagged, :approved)");
            $stmt->bindParam(':food_rating', $review->food_rating);
            $stmt->bindParam(':service_rating', $review->service_rating);
            $stmt->bindParam(':price_value_rating', $review->price_value_rating);
            $stmt->bindParam(':review_text', $review->review_text);
            $stmt->bindParam(':restaurant_id', $review->restaurant_id);
            $stmt->bindParam(':user_id', $review->user_id);
            $stmt->bindParam(':image', $review->image);
            $stmt->bindParam(':flagged', $review->flagged);
            $stmt->bindParam(':approved', $review->approved);
            $stmt->execute();

            // set the id of the review to the id of the newly created review
            $review->id = $this->connection->lastInsertId();

            return $review;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function updateReview($id, Review $review)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE Review SET food_rating = :food_rating, service_rating = :service_rating, price_value_rating = :price_value_rating, review_text = :review_text, restaurant_id = :restaurant_id, user_id = :user_id, image = :image, flagged = :flagged, approved = :approved WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':food_rating', $review->food_rating);
            $stmt->bindParam(':service_rating', $review->service_rating);
            $stmt->bindParam(':price_value_rating', $review->price_value_rating);
            $stmt->bindParam(':review_text', $review->review_text);
            $stmt->bindParam(':restaurant_id', $review->restaurant_id);
            $stmt->bindParam(':user_id', $review->user_id);
            $stmt->bindParam(':image', $review->image);
            $stmt->bindParam(':flagged', $review->flagged);
            $stmt->bindParam(':approved', $review->approved);
            $stmt->execute();

            // get the updated review
            $review = $this->getById($id);
            return $review;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function deleteReview($reviewId)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM Review WHERE id = :reviewId");
            $stmt->bindParam(':reviewId', $reviewId);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }

    public function flagReview($id)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE Review SET flagged = 1 WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();


            return true;
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }

    public function approveReview($id)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE Review SET approved = 1 WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }




// findApproved(): Find all approved reviews.
// findFlagged(): Find all flagged reviews.
// getAverageRatingByRestaurant($restaurantId): Get the average rating of a specific restaurant.
// getNumberOfReviewsByRestaurant($restaurantId): Get the number of reviews for a specific restaurant.
// getNumberOfReviewsByUser($userId): Get the number of reviews made by a specific user.
// search($query): Search for reviews based on a search query.
}
