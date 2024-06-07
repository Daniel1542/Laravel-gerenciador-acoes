import './bootstrap';
import { createApp } from 'vue';
import BuscarAtivo from './components/BuscarAtivo.vue';
import DashGrafico from './components/DashGrafico.vue';
import initBladeFormulaBazin from './bladeFormulaBazin.js';
import initBladeFormulaGraham from './bladeFormulaGraham.js';


initBladeFormulaBazin();
initBladeFormulaGraham();

const app = createApp({});
app.component('Buscar', BuscarAtivo);
app.component('Dash', DashGrafico);
app.mount('#app');
