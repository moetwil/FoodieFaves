<?php
namespace Repositories;

use PDO;
use PDOException;
use Models\User;

class UserRepository extends Repository
{
    public function getUserById($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM User WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\User');
            $user = $stmt->fetch();

            return $user;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getUserByUsername($username)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM User WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\User');
            $user = $stmt->fetch();

            return $user;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function checkUsernamePassword($username, $password)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM User WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\User');
            $user = $stmt->fetch();

            // verify if the password matches the hash in the database
            $result = password_verify($password, $user->getPassword());

            if (!$result) {
                return false;
            }

            // do not pass the password hash to the caller
            $user->setPassword("");

            return $user;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function addUser(User $user)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO User (first_name, last_name, username, email, password) VALUES (:first_name, :last_name, :username, :email, :password)");
            $stmt->bindParam(':first_name', $user->getFirstName());
            $stmt->bindParam(':last_name', $user->getLastName());
            $stmt->bindParam(':username', $user->getUsername());
            $stmt->bindParam(':email', $user->getEmail());
            $stmt->bindParam(':password', $user->getPassword());
            $stmt->execute();

            return $user;
        } catch (PDOException $e) {
            echo $e;
        }
    }


    public function updateUser(User $user)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE User SET first_name = :first_name, last_name = :last_name, username = :username, email = :email, password = :password WHERE id = :id");
            $stmt->bindParam(':first_name', $user->getFirstName());
            $stmt->bindParam(':last_name', $user->getLastName());
            $stmt->bindParam(':username', $user->getUsername());
            $stmt->bindParam(':email', $user->getEmail());
            $stmt->bindParam(':password', $user->getPassword());
            $stmt->bindParam(':id', $user->getId());
            $stmt->execute();

            return $user;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function deleteUser(User $user)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM User WHERE id = :id");
            $stmt->bindParam(':id', $user->getId());
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e;
        }
    }
}
