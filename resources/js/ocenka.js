
import { createApp } from 'vue';



const app = createApp({});

import AppOcenka from './components/ocenka/ocenka.vue';

app.component('app-ocenka', AppOcenka);

app.mount('#app');
