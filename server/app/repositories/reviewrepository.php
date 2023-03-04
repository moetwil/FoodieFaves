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
            $stmt = $this->connection->prepare("INSERT INTO Review (food_rating, service_rating, price_value_rating, review_text, date, restaurant_id, user_id, image, flagged, approved) VALUES (:food_rating, :service_rating, :price_value_rating, :review_text, :date, :restaurant_id, :user_id, :image, :flagged, :approved)");
            $stmt->bindParam(':food_rating', $review->foodRating);
            $stmt->bindParam(':service_rating', $review->serviceRating);
            $stmt->bindParam(':price_value_rating', $review->priceValueRating);
            $stmt->bindParam(':review_text', $review->reviewText);
            $stmt->bindParam(':date', $review->date);
            $stmt->bindParam(':restaurant_id', $review->restaurantId);
            $stmt->bindParam(':user_id', $review->userId);
            $stmt->bindParam(':image', $review->image);
            $stmt->bindParam(':flagged', $review->flagged);
            $stmt->bindParam(':approved', $review->approved);
            $stmt->execute();

            $reviewId = $this->connection->lastInsertId();
            $review->id = $reviewId;

            return $review;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function updateReview(Review $review)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE Review SET food_rating = :food_rating, service_rating = :service_rating, price_value_rating = :price_value_rating, review_text = :review_text, date = :date, restaurant_id = :restaurant_id, user_id = :user_id, image = :image, flagged = :flagged, approved = :approved WHERE id = :id");
            $stmt->bindParam(':id', $review->id);
            $stmt->bindParam(':food_rating', $review->foodRating);
            $stmt->bindParam(':service_rating', $review->serviceRating);
            $stmt->bindParam(':price_value_rating', $review->priceValueRating);
            $stmt->bindParam(':review_text', $review->reviewText);
            $stmt->bindParam(':date', $review->date);
            $stmt->bindParam(':restaurant_id', $review->restaurantId);
            $stmt->bindParam(':user_id', $review->userId);
            $stmt->bindParam(':image', $review->image);
            $stmt->bindParam(':flagged', $review->flagged);
            $stmt->bindParam(':approved', $review->approved);
            $stmt->execute();

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

    public function flagReview(Review $review)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE Review SET flagged = 1 WHERE id = :id");
            $stmt->bindParam(':id', $review->id);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }

    public function approveReview(Review $review)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE Review SET approved = 1 WHERE id = :id");
            $stmt->bindParam(':id', $review->id);
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
