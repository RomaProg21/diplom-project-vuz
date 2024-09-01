
import { createApp } from 'vue';



const app = createApp({});

import recordBook from './components/recordBook/recordBook.vue';

app.component('record-book', recordBook);

app.mount('#app');
