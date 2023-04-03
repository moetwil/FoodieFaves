import { defineStore } from 'pinia';
import axios from '../utils/axios';
import Review from '../interfaces/Review';

export const useReviewStore = defineStore({
  id: 'review',
  state: () => ({
    review: null as Review | null,
  }),
  getters: {
    getReview(): Review | null {
      return this.review;
    },
  },
  actions: {
    setReview(review: Review) {
      this.review = review;
    },
    setImage(image: string) {
      this.review!.image = image;
    },
    async createReview() {
      const newReview = {
        food_rating: this.review!.food_rating,
        service_rating: this.review!.service_rating,
        price_value_rating: this.review!.price_value_rating,
        review_text: this.review!.review_text,
        restaurant_id: this.review!.restaurant_id,
        user_id: this.review!.user_id,
        image: this.review!.image,
      };

      try {
        const response = await axios.post('/reviews', newReview);
        this.review = response.data;
      } catch (error) {
        console.log(error);
      }
    },
  },
});
