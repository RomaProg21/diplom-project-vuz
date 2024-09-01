
import { createApp } from 'vue';

 

const app = createApp({});

import predmets from './components/predmets/predmetsSearch.vue';

app.component('predmets', predmets);

app.mount('#app');
