
import { createApp } from 'vue';

 

const app = createApp({});

import SheduleExam from './components/sheduleExam/sheduleExam.vue';

app.component('shedule-exam', SheduleExam);

app.mount('#app');
