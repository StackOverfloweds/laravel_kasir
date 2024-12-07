import { createApp } from 'vue';
import App from './App.vue';
import router from './router';  // Importing the router from the 'router/index.js'
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// import './style.css'; 

createApp(App)
  .use(router)  // Use the router with the Vue app
  .mount('#app');  // Mount the app to the DOM element with id "app"
