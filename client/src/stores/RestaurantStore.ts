import { defineStore } from 'pinia';
import axios from '../utils/axios';
import Restaurant from '../interfaces/Restaurant';
import Review from '../interfaces/Review';

export const useRestaurantStore = defineStore({
  id: 'restaurant',
  state: () => ({
    restaurant: null as Restaurant | null,
    reviews: [] as Review[],
    averageRating: 0,
    averageFoodRating: 0,
    averageServiceRating: 0,
    averagePriceValueRating: 0,
  }),
  actions: {
    async fetchRestaurant(id: string) {
      try {
        const response = await axios.get(`/restaurants/${id}`);
        this.restaurant = response.data;
      } catch (error) {
        console.error(error);
      }
    },
    async fetchReviews(id: string) {
      try {
        const response = await axios.get(`/reviews/restaurant/${id}`);
        this.reviews = response.data;
        this.calculateRatings();
      } catch (error) {
        console.error(error);
      }
    },
    async fetchAverageRating(id: string) {
      try {
        const response = await axios.get(`/restaurants/${id}/rating`);

        // set with 1 decimal
        response.data = Math.round(response.data * 10) / 10;
        this.averageRating = response.data;
      } catch (error) {
        console.error(error);
      }
    },
    calculateRatings() {
      const sum = this.reviews.reduce(
        (acc, review) => {
          return {
            foodRating: acc.foodRating + review.food_rating,
            serviceRating: acc.serviceRating + review.service_rating,
            priceValueRating: acc.priceValueRating + review.price_value_rating,
          };
        },
        { foodRating: 0, serviceRating: 0, priceValueRating: 0 }
      );

      const length = this.reviews.length;
      this.averageFoodRating = Math.round(sum.foodRating / length);
      this.averageServiceRating = Math.round(sum.serviceRating / length);
      this.averagePriceValueRating = Math.round(sum.priceValueRating / length);
    },
  },
});
