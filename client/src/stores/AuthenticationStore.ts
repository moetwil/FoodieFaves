import { defineStore } from 'pinia';
import { useRouter } from 'vue-router';
import axios from '../utils/axios';
import User from '../interfaces/User';

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
    async login(username: string, password: string) {
      try {
        const response = await axios.post('/users/login', {
          username: username,
          password: password,
        });

        const data = response.data;

        if (data.message === 'Successful login.') {
          console.log('LOGIN');
          // set token in local storage
          localStorage.setItem('token', data.token);
          localStorage.setItem('user_id', data.user._id);

          // set user in state
          this.user = data.user;
          this.isLoggedIn = true;

          return true;
        } else {
          return false;
        }
      } catch (error: any) {
        alert(error.message);
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
  },
});
