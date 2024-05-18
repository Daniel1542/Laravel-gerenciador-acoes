import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});

import Home from './components/Home.vue';
app.component('Home', Home);

app.mount('#app');
