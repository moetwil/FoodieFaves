import { defineStore } from 'pinia';
// import { useRouter } from 'vue-router';
import axios from '../utils/axios';
import User from '../interfaces/User';
import Login from '../interfaces/login';

interface AuthState {
  user: User | null;
  isLoggedIn: boolean;
}

// STORE
export const useAuthenticationStore = defineStore({
  id: 'authentication',
  state: (): AuthState => ({
    user: null,
    isLoggedIn: localStorage.getItem('token') !== null,
  }),
  getters: {
    getUser(state) {
      return state.user;
    },
    getIsLoggedIn(state) {
      return state.isLoggedIn;
    },
    getIsRestaurantOwner(state) {
      return state.user?.user_type === 1;
    },
  },
  actions: {
    async login(data: Login) {
      try {
        const response = await axios.post('/users/login', {
          username: data.username,
          password: data.password,
        });
        if (response.status === 200) {
          this.setUser(response.data.user, response.data.jwt);
          this.router.push('/');
        }
      } catch (error: any) {
        return error;
      }
    },
    logout() {
      localStorage.removeItem('token');
      localStorage.removeItem('user_id');
      localStorage.removeItem('user_type');
      this.user = null;
      this.isLoggedIn = false;

      this.router.push('/login');
    },
    async register(newUser: User) {
      try {
        const response = await axios.post('/users/register', newUser);
        if (response.status === 200) {
          this.setUser(response.data.user, response.data.jwt);
          this.router.push('/');
        }
      } catch (error: any) {
        console.error(error);
      }
    },
    async updateUser(updateUser: User) {
      this.user = updateUser;
      try {
        const response = await axios.put(`/users/${updateUser.id}`, updateUser);
        this.user.password = undefined;
        console.log(response);
        if (response.status === 200) return true;
      } catch (error: any) {
        alert(error.message);
        return false;
      }
    },
    setUser(user: User, token: string) {
      // set token in local storage
      localStorage.setItem('token', token);
      localStorage.setItem('user_id', user.id?.toString() || '');
      localStorage.setItem('user_type', user.user_type?.toString() || '');
      // set user in state
      this.user = user;
      this.isLoggedIn = true;
    },
    async checkAuth() {
      const userId = localStorage.getItem('user_id');
      if (userId && this.user === null) {
        const response = await axios.get('/users/' + userId);
        // console.log(response.data);
        this.setUser(response.data, localStorage.getItem('token') || '');
      }
    },
  },
});
