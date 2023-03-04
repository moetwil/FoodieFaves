import axios from 'axios';

const instance = axios.create({
  baseURL: 'http://localhost/api',
  headers: {
    'Content-Type': 'application/json',
    Authorization: localStorage.getItem('token'),
  },
});

export default instance;
