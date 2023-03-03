<?php
namespace Models;

class Review {
    private $id;
    private $foodRating;
    private $serviceRating;
    private $priceValueRating;
    private $reviewText;
    private $date;
    private $restaurantId;
    private $userId;
    private $image;
    private $flagged;
    private $approved;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getFoodRating() {
        return $this->foodRating;
    }

    public function setFoodRating($foodRating) {
        $this->foodRating = $foodRating;
    }

    public function getServiceRating() {
        return $this->serviceRating;
    }

    public function setServiceRating($serviceRating) {
        $this->serviceRating = $serviceRating;
    }

    public function getPriceValueRating() {
        return $this->priceValueRating;
    }

    public function setPriceValueRating($priceValueRating) {
        $this->priceValueRating = $priceValueRating;
    }

    public function getReviewText() {
        return $this->reviewText;
    }

    public function setReviewText($reviewText) {
        $this->reviewText = $reviewText;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getRestaurantId() {
        return $this->restaurantId;
    }

    public function setRestaurantId($restaurantId) {
        $this->restaurantId = $restaurantId;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function isFlagged() {
        return $this->flagged;
    }

    public function setFlagged($flagged) {
        $this->flagged = $flagged;
    }

    public function isApproved() {
        return $this->approved;
    }

    public function setApproved($approved) {
        $this->approved = $approved;
    }
}
