import { createApp, markRaw } from 'vue';
import App from './App.vue';
import router from './router';
import type { Router } from 'vue-router';
import { createPinia } from 'pinia';

/* import CSS*/
import './assets/main.css';

/* FontAwesome icons */
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {
  faUserSecret,
  faPencil,
  faUser,
  faUtensils,
  faBuilding,
  faTrash,
  faPenToSquare,
  faQuoteLeft,
  faFlag,
} from '@fortawesome/free-solid-svg-icons';
library.add(
  faUserSecret,
  faPencil,
  faUser,
  faUtensils,
  faBuilding,
  faTrash,
  faPenToSquare,
  faQuoteLeft,
  faFlag
);

// Create app
const app = createApp(App);
app.use(router);

// Add router to pinia
const pinia = createPinia();
pinia.use(({ store }) => {
  store.router = markRaw(router);
});

app.use(pinia);
app.component('font-awesome-icon', FontAwesomeIcon);
app.mount('#app');

// declare module 'pinia' with router
declare module 'pinia' {
  export interface PiniaCustomProperties {
    router: Router;
  }
}
