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
  },
  actions: {
    async login(data: Login) {
      const response = await axios.post('/users/login', {
        username: data.username,
        password: data.password,
      });

      if (response.status === 200) {
        // set token in local storage
        localStorage.setItem('token', response.data.token);
        localStorage.setItem('user_id', response.data.user._id);
        // set user in state
        this.user = response.data.user;
        this.isLoggedIn = true;

        this.router.push('/');
      }
    },

    logout() {
      localStorage.removeItem('token');
      localStorage.removeItem('user_id');
      this.user = null;
      this.isLoggedIn = false;

      return true;
    },
    async register(newUser: User) {
      try {
        const response = await axios.post('/users/register', newUser);
        if (response.status === 200) return true;
      } catch (error: any) {
        alert(error.message);
        return false;
      }
    },
    async updateUser(updateUser: User) {
      this.user = updateUser;
      try {
        const response = await axios.put(`/users/${updateUser.id}`, updateUser);
        console.log(response);
        if (response.status === 200) return true;
      } catch (error: any) {
        alert(error.message);
        return false;
      }
    },
  },
});
