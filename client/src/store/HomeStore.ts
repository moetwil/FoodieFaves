import { defineStore } from 'pinia';
import Restaurant from '../interfaces/Restaurant';
import Review from '../interfaces/Review';

// Define the shape of our state
interface State {
  restaurants: Restaurant[];
  latestReviews: Review[];
}

// Define a default state to use when initializing the store
const defaultState: State = {
  restaurants: [],
  latestReviews: [],
};

export const useRestaurantReviewStore = defineStore({
  id: 'restaurant-review-store',
  state: defaultState,
  getters: {
    // Getter to return 3 random restaurants
    randomRestaurants(state) {
      return state.restaurants.sort(() => Math.random() - 0.5).slice(0, 3);
    },
    // Getter to return the 2 latest reviews
    latestReviews(state) {
      return state.latestReviews.slice(0, 2);
    },
  },
  actions: {
    // Action to fetch all restaurants and store them in state
    async fetchAllRestaurants() {
      const response = await fetch('/api/restaurants');
      const restaurants = await response.json();
      this.state.restaurants = restaurants;
    },
    // Action to fetch the latest reviews and user information for each review
    async fetchLatestReviews() {
      const response = await fetch('/api/reviews?limit=2');
      const reviews = await response.json();
      for (const review of reviews) {
        const userResponse = await fetch(`/api/users/${review.userId}`);
        const user = await userResponse.json();
        review.user = user;
      }
      this.state.latestReviews = reviews;
    },
  },
});
