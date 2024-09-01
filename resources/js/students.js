
import { createApp } from 'vue';



const app = createApp({});

import AppStudents from './components/students/AppStudents.vue';
app.component('app-students', AppStudents);


app.mount('#app');
