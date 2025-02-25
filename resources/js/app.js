// resources/js/app.js
import { createApp } from 'vue';
import App from './pages/ProductList.vue';
import router from './router';
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';


// import 'primeicons/primeicons.css';

const app = createApp(App);
app.use(PrimeVue, {
    theme: {
        preset: Aura,
        dark: false,
        options: {
            darkModeSelector: '.my-app-dark',
        }

    }
});
app.use(router);
app.mount('#app');
