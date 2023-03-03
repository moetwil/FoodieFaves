<?php
namespace Models;

class User {
  private $id;
  private $firstName;
  private $lastName;
  private $username;
  private $email;
  private $password;
  private $profilePicture;
  private $isAdmin;
  private $userType;

  public function __construct($id, $firstName, $lastName, $username, $email, $password, $profilePicture, $isAdmin, $userType) {
    $this->id = $id;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->username = $username;
    $this->email = $email;
    $this->password = $password;
    $this->profilePicture = $profilePicture;
    $this->isAdmin = $isAdmin;
    $this->userType = $userType;
  }

  public function getId() {
    return $this->id;
  }

  public function getFirstName() {
    return $this->firstName;
  }

  public function setFirstName($firstName) {
    $this->firstName = $firstName;
  }

  public function getLastName() {
    return $this->lastName;
  }

  public function setLastName($lastName) {
    $this->lastName = $lastName;
  }

  public function getUsername() {
    return $this->username;
  }

  public function setUsername($username) {
    $this->username = $username;
  }

  public function getEmail() {
    return $this->email;
  }

  public function setEmail($email) {
    $this->email = $email;
  }

  public function getPassword() {
    return $this->password;
  }

  public function setPassword($password) {
    $this->password = $password;
  }

  public function getProfilePicture() {
    return $this->profilePicture;
  }

  public function setProfilePicture($profilePicture) {
    $this->profilePicture = $profilePicture;
  }

  public function getIsAdmin() {
    return $this->isAdmin;
  }

  public function setIsAdmin($isAdmin) {
    $this->isAdmin = $isAdmin;
  }

  public function getUserType() {
    return $this->userType;
  }

  public function setUserType($userType) {
    $this->userType = $userType;
  }
}

