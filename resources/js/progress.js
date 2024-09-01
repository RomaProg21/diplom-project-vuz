
import { createApp } from 'vue';



const app = createApp({});

import progress from './components/progress/progress.vue';

app.component('progress-app', progress);

app.mount('#app');
