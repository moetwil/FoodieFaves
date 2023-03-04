<?php
namespace Models;

class Review {
    public $id;
    public $food_rating;
    public $service_rating;
    public $price_value_rating;
    public $review_text;
    public $date;
    public $restaurant_id;
    public $user_id;
    public $image;
    public $flagged;
    public $approved;
}
