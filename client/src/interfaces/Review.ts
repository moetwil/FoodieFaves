interface Review {
  id: number;
  food_rating: number;
  service_rating: number;
  price_value_rating: number;
  review_text: string;
  date: string;
  restaurant_id: number;
  user_id: number;
  image: string;
  flagged: boolean;
  approved: boolean;
}

export default Review;
