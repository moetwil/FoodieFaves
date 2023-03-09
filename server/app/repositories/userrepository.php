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
            $stmt = $this->connection->prepare("SELECT id, first_name, last_name, username, email, password, is_admin, user_type, profile_picture FROM User WHERE id = :id");
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
            $stmt = $this->connection->prepare("SELECT id, first_name, last_name, username, email, password, is_admin, user_type, profile_picture FROM User WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\User');
            $user = $stmt->fetch();

            if(!$user) {
                return ;
            }

            return $user;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getUserByEmail($email)
    {
        try {
            $stmt = $this->connection->prepare("SELECT id, first_name, last_name, username, email, password, is_admin, user_type, profile_picture FROM User WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\User');
            $user = $stmt->fetch();

            if(!$user) {
                return ;
            }

            // get the user's profile picture
            $user->profile_picture = $this->getUserPicture($user->id);

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
            $result = password_verify($password, $user->password);

            if (!$result) {
                return false;
            }

            // do not pass the password hash to the caller
            $user->password = null;

            return $user;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function createUser(User $user)
    {
        try {

            // hash the password
            $user->password = $this->hashPassword($user->password);

            $stmt = $this->connection->prepare("INSERT INTO User (first_name, last_name, username, email, password, profile_picture, user_type) VALUES (:first_name, :last_name, :username, :email, :password, :profile_picture, :user_type)");
            $stmt->bindParam(':first_name', $user->first_name);
            $stmt->bindParam(':last_name', $user->last_name);
            $stmt->bindParam(':username', $user->username);
            $stmt->bindParam(':email', $user->email);
            $stmt->bindParam(':password', $user->password);
            $stmt->bindParam(':user_type', $user->user_type);
            $stmt->bindParam(':profile_picture', $user->profile_picture);
            $stmt->execute();

            // get the id of the newly created user
            $user->id = $this->connection->lastInsertId();

            // remove password
            $user->password = null;

            return $user;
        } catch (PDOException $e) {
            echo $e;
        }
    }


    public function updateUser($id, User $user)
    {
        try {

            // hash the password
            $user->password = $this->hashPassword($user->password);

            $stmt = $this->connection->prepare("UPDATE User SET first_name = :first_name, last_name = :last_name, username = :username, email = :email, password = :password, is_admin = :is_admin WHERE id = :id");
            $stmt->bindParam(':first_name', $user->first_name);
            $stmt->bindParam(':last_name', $user->last_name);
            $stmt->bindParam(':username', $user->username);
            $stmt->bindParam(':email', $user->email);
            $stmt->bindParam(':password', $user->password);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':is_admin', $user->is_admin);
            $stmt->execute();

            // remove password
            $user->password = null;

            return $user;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function deleteUser($id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM User WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // return true if the user was deleted else return false
            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            echo $e;
        }
    }

    // hash the password (currently uses bcrypt)
    function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    // verify the password hash
    function verifyPassword($input, $hash)
    {
        return password_verify($input, $hash);
    }

    function getUserPicture($id){
        try {
            $stmt = $this->connection->prepare("SELECT profile_picture FROM User WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $userPicture = $stmt->fetchColumn();

            if($userPicture == null){
                return null;
            }
            // convert blob to base64
            $userPicture = base64_encode($userPicture);


            return $userPicture;
        } catch (PDOException $e) {
            echo $e;
        }
    }
}
