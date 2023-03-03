<?php
namespace Models;

class Restaurant {
  private $id;
  private $name;
  private $street;
  private $houseNumber;
  private $city;
  private $zipCode;
  private $country;
  private $phoneNumber;
  private $ownerId;
  private $profilePicture;
  private $restaurantTypeId;

  public function __construct($name, $street, $houseNumber, $city, $zipCode, $country, $phoneNumber, $ownerId, $profilePicture, $restaurantTypeId) {
    $this->name = $name;
    $this->street = $street;
    $this->houseNumber = $houseNumber;
    $this->city = $city;
    $this->zipCode = $zipCode;
    $this->country = $country;
    $this->phoneNumber = $phoneNumber;
    $this->ownerId = $ownerId;
    $this->profilePicture = $profilePicture;
    $this->restaurantTypeId = $restaurantTypeId;
  }

  public function getId() {
    return $this->id;
  }

  public function getName() {
    return $this->name;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public function getStreet() {
    return $this->street;
  }

  public function setStreet($street) {
    $this->street = $street;
  }

  public function getHouseNumber() {
    return $this->houseNumber;
  }

  public function setHouseNumber($houseNumber) {
    $this->houseNumber = $houseNumber;
  }

  public function getCity() {
    return $this->city;
  }

  public function setCity($city) {
    $this->city = $city;
  }

  public function getZipCode() {
    return $this->zipCode;
  }

  public function setZipCode($zipCode) {
    $this->zipCode = $zipCode;
  }

  public function getCountry() {
    return $this->country;
  }

  public function setCountry($country) {
    $this->country = $country;
  }

  public function getPhoneNumber() {
    return $this->phoneNumber;
  }

  public function setPhoneNumber($phoneNumber) {
    $this->phoneNumber = $phoneNumber;
  }

  public function getOwnerId() {
    return $this->ownerId;
  }

  public function setOwnerId($ownerId) {
    $this->ownerId = $ownerId;
  }

  public function getProfilePicture() {
    return $this->profilePicture;
  }

  public function setProfilePicture($profilePicture) {
    $this->profilePicture = $profilePicture;
  }

  public function getRestaurantTypeId() {
    return $this->restaurantTypeId;
  }

  public function setRestaurantTypeId($restaurantTypeId) {
    $this->restaurantTypeId = $restaurantTypeId;
  }
}
