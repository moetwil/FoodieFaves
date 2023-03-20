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

        // read user data from request body
        $postedUser = $this->createObjectFromPostedJson("Models\\User");

        // get user from db
        $user = $this->service->authenticateUser($postedUser->username, $postedUser->password);

        // if the method returned false, the username and/or password were incorrect
        if(!$user) {
            $this->respondWithError(401, "Invalid login");
            return;
        }

        // generate jwt
        $tokenResponse = $this->generateJwt($user);       

        $this->respond($tokenResponse);    
    }

    public function register() {
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
    }

    public function update($id){
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
    }

    public function delete($id){
        $res = $this->service->deleteUser($id);
        
        if($res) {
            $this->respond("User deleted");
        } else {
            $this->respondWithError(500, "User could not be deleted");
        }
    }

    public function getById($id) {
        $user = $this->service->getUserById($id);

        if($user) {
            $this->respond($user);
        } else {
            $this->respondWithError(404, "User not found");
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
        $expire = $issuedAt + 600;

        $payload = array(
            "iss" => $issuer,
            "aud" => $audience,
            "iat" => $issuedAt,
            "nbf" => $notbefore,
            "exp" => $expire,
            "data" => array(
                "id" => $user->id,
                "username" => $user->username,
        ));

        $jwt = JWT::encode($payload, $secret_key, 'HS256');

        return 
            array(
                "message" => "Successful login.",
                "jwt" => $jwt,
                "user" => $user,
                "expireAt" => $expire
            );
    }    
}
