import { createApp } from 'vue'
import App from './App.vue'
import store from './store';
import router from './router';
import './styles.scss'
import '@fortawesome/fontawesome-free/css/all.css';

createApp(App)
    .use(store)
    .use(router)
    .mount('#app')
