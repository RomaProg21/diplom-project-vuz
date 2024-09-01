
import { createApp } from 'vue';



const app = createApp({});

import info from './components/info/info.vue';

app.component('info-app', info);

app.mount('#app');
