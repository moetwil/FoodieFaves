<?php
namespace Repositories;

use PDO;
use Models\Restaurant;
use PDOException;

class RestaurantRepository  extends Repository{

    public function getRestaurantById($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM Restaurant WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Restaurant');
            $restaurant = $stmt->fetch();

            return $restaurant;

            
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function createRestaurant(Restaurant $restaurant)
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
            $stmt->bindParam(':owner_id', $restaurant->owner_id);
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
            $stmt = $this->connection->prepare("DELETE FROM Restaurant WHERE id = :id");
            $stmt->bindParam(':id', $restaurantId);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }


    public function getAllRestaurants() 
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM Restaurant");
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Restaurant');
            $restaurants = $stmt->fetchAll();

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

}