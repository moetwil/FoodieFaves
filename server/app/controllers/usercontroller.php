<?php

namespace Controllers;

use Exception;
use Services\UserService;
use \Firebase\JWT\JWT;
use \Dotenv\Dotenv;

class UserController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new UserService();
    }

    public function login() {
        try{
            // read user data from request body
            $postedUser = $this->createObjectFromPostedJson("Models\\User");

            // get user from db and check if valid
            $user = $this->service->authenticateUser($postedUser->username, $postedUser->password);
            if(!$user) {
                $this->respondWithError(401, "Invalid login");
                return;
            }

            // generate jwt
            $tokenResponse = $this->generateJwt($user);       
            $this->respond($tokenResponse); 
        } catch(Exception $e){
            $this->respondWithError(500, $e->getMessage());
        }
           
    }

    public function register() {
        try{
            // read user data from request body
            $postedUser = $this->createObjectFromPostedJson("Models\\User");

            // check if the username already exists
            $user = $this->service->getUserByUsername($postedUser->username);
            if($user) {
                $this->respondWithError(409, "Username already exists");
                return;
            }

            // check if the email already exists
            $user = $this->service->getUserByEmail($postedUser->email);
            if($user) {
                $this->respondWithError(409, "Email already exists");
                return;
            }

            //create user
            $user = $this->service->createUser($postedUser);

            // generate jwt
            $tokenResponse = $this->generateJwt($user);       
            $this->respond($tokenResponse);   
        } catch(Exception $e){
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function update($id){
        try{
            // verify JWT and check if user is authorized
            $decoded = $this->checkForJwt();
            if(!$decoded) return;

            // check if the user is authorized to update the user
            if($decoded->data->id != $id) {
                $this->respondWithError(401, "Unauthorized, you can only update your own user");
                return;
            }

            // read user data from request body
            $postedUser = $this->createObjectFromPostedJson("Models\\User");
            
            // check if the username already exists
            $user = $this->service->getUserByUsername($postedUser->username);
            if($user && $user->id != $id) {
                $this->respondWithError(409, "Username already exists");
                return;
            }

            // check if the email already exists
            $user = $this->service->getUserByEmail($postedUser->email);
            if($user && $user->id != $id) {
                $this->respondWithError(409, "Email already exists");
                return;
            }

            // update user
            $user = $this->service->updateUser($id, $postedUser);
            $this->respond($user);
        } catch(Exception $e){
            $this->respondWithError(500, $e->getMessage());
        }
        
    }

    public function delete($id){
        try{
            // delete the user
            $res = $this->service->deleteUser($id);
            
            // check if the user was deleted and send response accordingly
            if($res) {
                $this->respond("User deleted");
            } else {
                $this->respondWithError(500, "User could not be deleted");
            }
        }
        catch(Exception $e){
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function getById($id) {
        try{
            $user = $this->service->getUserById($id);

            if($user) {
                $this->respond($user);
            } else {
                $this->respondWithError(404, "User not found");
            }
        }catch(Exception $e){
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function generateJwt($user) {
        // SECRET KEY TODO: change and store in .env
        $secret_key = "gF9yx9bszP9em3f4";

        // JWT DATA
        $issuer = "localhost";
        $audience = "FoodieFaves";
        $issuedAt = time();
        $notbefore = $issuedAt;
        $expire = $issuedAt + 1200;

        // PAYLOAD DATA
        $payload = array(
            "iss" => $issuer,
            "aud" => $audience,
            "iat" => $issuedAt,
            "nbf" => $notbefore,
            // "exp" => $expire,
            "data" => array(
                "id" => $user->id,
                "username" => $user->username,
        ));

        // ENCODE JWT
        $jwt = JWT::encode($payload, $secret_key, 'HS256');

        return 
            array(
                "message" => "Successful login.",
                "jwt" => $jwt,
                "user" => $user,
                // "expireAt" => $expire
            );
    }    
}
