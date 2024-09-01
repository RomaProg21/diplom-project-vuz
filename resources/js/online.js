
import { createApp } from 'vue';

 

const app = createApp({});

import online from './components/online/online.vue';

app.component('online', online);

app.mount('#app');
