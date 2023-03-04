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

    public function generateJwt($user) {
        $secret_key = getenv('JWT_SECRET_KEY');

        $issuer = "localhost"; // this can be the domain/servername that issues the token
        $audience = "FoodieFaves"; // this can be the domain/servername that checks the token

        $issuedAt = time(); // issued at
        $notbefore = $issuedAt; //not valid before 
        $expire = $issuedAt + 600; // expiration time is set at +600 seconds (10 minutes)

        // JWT expiration times should be kept short (10-30 minutes)
        // A refresh token system should be implemented if we want clients to stay logged in for longer periods

        // note how these claims are 3 characters long to keep the JWT as small as possible
        $payload = array(
            "iss" => $issuer,
            "aud" => $audience,
            "iat" => $issuedAt,
            "nbf" => $notbefore,
            "exp" => $expire,
            "data" => array(
                "id" => $user->id,
                "username" => $user->username,
                "email" => $user->email
        ));

        $jwt = JWT::encode($payload, $secret_key, 'HS256');

        return 
            array(
                "message" => "Successful login.",
                "jwt" => $jwt,
                "username" => $user->username,
                "expireAt" => $expire
            );
    }    
}
