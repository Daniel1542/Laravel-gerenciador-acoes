import './bootstrap';
import { createApp } from 'vue';
import DashGrafico from './components/DashGrafico.vue';

function initDashGrafico() {
  console.log('Inicializando o Vue DashGrafico...');
}

document.addEventListener('DOMContentLoaded', () => {
    const appElement = document.getElementById('app');
    const app = createApp({});
    app.component('Dashgraficos', DashGrafico);
    app.mount('#app');
});

export default initDashGrafico;