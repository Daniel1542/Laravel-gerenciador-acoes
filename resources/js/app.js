import './bootstrap';
import { createApp } from 'vue';
import BuscarAtivo from './components/BuscarAtivo.vue';
import BotoesFormula from './components/BotoesFormula.vue';
import DashGrafico from './components/DashGrafico.vue';
import initBladeFormula from './bladeFormula.js';

initBladeFormula();

const app = createApp({});
app.component('Botoes', BotoesFormula);
app.component('Buscar', BuscarAtivo);
app.component('Dash', DashGrafico);
app.mount('#app');