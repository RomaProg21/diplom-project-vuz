
import { createApp } from 'vue';



const app = createApp({});

import statments from './components/statments/statments.vue';

app.component('statments', statments);

app.mount('#app');
