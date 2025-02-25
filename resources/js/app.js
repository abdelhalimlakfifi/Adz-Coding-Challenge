// resources/js/app.js
import { createApp } from 'vue';
import App from './pages/ProductList.vue';
import router from './router';

createApp(App).use(router).mount('#app');
