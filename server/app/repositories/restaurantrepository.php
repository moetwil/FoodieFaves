<?php
namespace Repositories;

use PDO;
use Models\{Restaurant, User};
use PDOException;

class RestaurantRepository  extends Repository{

    public function getRestaurantById($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT id, name, street, house_number, city, zip_code, country, phone_number, owner_id, restaurant_type_id FROM Restaurant WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Restaurant');
            $restaurant = $stmt->fetch();
            
            // $restaurant->profile_picture = $this->getRestaurantPicture($restaurant->id);

            return $restaurant;

            
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function createRestaurant(Restaurant $restaurant, $userId)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO Restaurant (name, street, house_number, city, zip_code, country, phone_number, owner_id, profile_picture, restaurant_type_id) VALUES (:name, :street, :house_number, :city, :zip_code, :country, :phone_number, :owner_id, :profile_picture, :restaurant_type_id)");
            $stmt->bindParam(':name', $restaurant->name);
            $stmt->bindParam(':street', $restaurant->street);
            $stmt->bindParam(':house_number', $restaurant->house_number);
            $stmt->bindParam(':city', $restaurant->city);
            $stmt->bindParam(':zip_code', $restaurant->zip_code);
            $stmt->bindParam(':country', $restaurant->country);
            $stmt->bindParam(':phone_number', $restaurant->phone_number);
            $stmt->bindParam(':owner_id', $userId);
            $stmt->bindParam(':profile_picture', $restaurant->profile_picture);
            $stmt->bindParam(':restaurant_type_id', $restaurant->restaurant_type_id);
            $stmt->execute();

            // get the id of the inserted restaurant
            $restaurant->id = $this->connection->lastInsertId();

            return $restaurant;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function updateRestaurant($id, Restaurant $restaurant)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE Restaurant SET name = :name, street = :street, house_number = :house_number, city = :city, zip_code = :zip_code, country = :country, phone_number = :phone_number, owner_id = :owner_id, profile_picture = :profile_picture, restaurant_type_id = :restaurant_type_id WHERE id = :id");
            $stmt->bindParam(':name', $restaurant->name);
            $stmt->bindParam(':street', $restaurant->street);
            $stmt->bindParam(':house_number', $restaurant->house_number);
            $stmt->bindParam(':city', $restaurant->city);
            $stmt->bindParam(':zip_code', $restaurant->zip_code);
            $stmt->bindParam(':country', $restaurant->country);
            $stmt->bindParam(':phone_number', $restaurant->phone_number);
            $stmt->bindParam(':owner_id', $restaurant->owner_id);
            $stmt->bindParam(':profile_picture', $restaurant->profile_picture);
            $stmt->bindParam(':restaurant_type_id', $restaurant->restaurant_type_id);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return $restaurant;
        } catch (PDOException $e) {
            echo $e;
        }
    }


    public function deleteRestaurant($restaurantId) 
    {
        try {
            // start transaction
            $this->connection->beginTransaction();

            // delete all reviews of the restaurant
            $stmt = $this->connection->prepare("DELETE FROM Review WHERE restaurant_id = :id");
            $stmt->bindParam(':id', $restaurantId);
            $stmt->execute();

            // delete restaurant
            $stmt = $this->connection->prepare("DELETE FROM Restaurant WHERE id = :id");
            $stmt->bindParam(':id', $restaurantId);
            $stmt->execute();

            // commit transaction
            $this->connection->commit();

            return true;
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }


    public function getAllRestaurants() 
    {
        try {
            $stmt = $this->connection->prepare("SELECT id, name, street, house_number, city, zip_code, country, phone_number, owner_id, restaurant_type_id, profile_picture FROM Restaurant");
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Restaurant');
            $restaurants = $stmt->fetchAll();

            // foreach($restaurants as $restaurant){
            //     $restaurant->profile_picture = $this->getRestaurantPicture($restaurant->id);
            // }

            return $restaurants;
        } catch (PDOException $e) {
            echo $e;
        }
    }


    public function getAllRestaurantsByOwner($ownerId) 
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM Restaurant WHERE owner_id = :owner_id");
            $stmt->bindParam(':owner_id', $ownerId);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Restaurant');
            $restaurants = $stmt->fetchAll();

            // // get the profile picture of the restaurant
            // foreach($restaurants as $restaurant){
            //     $restaurant->profile_picture = $this->getRestaurantPicture($restaurant->id);
            // }

            return $restaurants;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getRestaurantReviewsAmount($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT COUNT(*) FROM Review WHERE restaurant_id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $reviewsAmount = $stmt->fetchColumn();

            return $reviewsAmount;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getRestaurantPicture($id){
        try {
            $stmt = $this->connection->prepare("SELECT profile_picture FROM Restaurant WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $restaurantPicture = $stmt->fetchColumn();

            if($restaurantPicture == null){
                return null;
            }
            // convert blob to base64
            $restaurantPicture = base64_encode($restaurantPicture);


            return $restaurantPicture;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    // create a function to get the average rating of a restaurant from the the 3 columns food_rating, service_rating, price_value_rating and return a value 1-5
    public function getRestaurantRating($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT (AVG(food_rating) + AVG(service_rating) + AVG(price_value_rating)) / 3 AS rating_avg
            FROM Review
            WHERE restaurant_id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $restaurantRating = $stmt->fetchColumn();

            return $restaurantRating;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function search($query){
        try {
            $stmt = $this->connection->prepare("SELECT id, name, street, house_number, city, zip_code, country, phone_number, owner_id, restaurant_type_id FROM `Restaurant` WHERE name LIKE :query OR city LIKE :query");
            $stmt->bindParam(':query', $query);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Restaurant');
            $restaurants = $stmt->fetchAll();

            // foreach($restaurants as $restaurant){
            //     $restaurant->profile_picture = $this->getRestaurantPicture($restaurant->id);
            // }

            return $restaurants;
        } catch (PDOException $e) {
            echo $e;
        }
    }

}