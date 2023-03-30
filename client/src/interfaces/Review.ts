interface Review {
  id: number | null;
  food_rating: number;
  service_rating: number;
  price_value_rating: number;
  review_text: string;
  date: string | null;
  restaurant_id: number;
  user_id: number;
  image: string | null;
  flagged: boolean | null;
  approved: boolean;
}

export default Review;
