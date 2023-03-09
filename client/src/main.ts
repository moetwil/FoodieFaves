import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { createPinia } from 'pinia';

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core';

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

/* import specific icons */
import {
  faUserSecret,
  faPencil,
  faUser,
} from '@fortawesome/free-solid-svg-icons';

/* add icons to the library */
library.add(faUserSecret, faPencil, faUser);

import './assets/main.css';

const app = createApp(App);

app.use(router);
app.use(createPinia());

app.component('font-awesome-icon', FontAwesomeIcon);

app.mount('#app');
