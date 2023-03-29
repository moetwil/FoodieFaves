<?php
namespace Repositories;

use PDO;
use Models\RestaurantType;
use PDOException;

class RestaurantTypeRepository  extends Repository{

    public function getAllRestaurantTypes() 
    {
        try {
            $stmt = $this->connection->prepare("SELECT id, name FROM RestaurantType");
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\RestaurantType');
            $restaurantTypes = $stmt->fetchAll();

            return $restaurantTypes;
        } catch (PDOException $e) {
            echo $e;
        }
    }
}