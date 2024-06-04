import './bootstrap';
import { createApp } from 'vue';
import BuscarAtivo from './components/BuscarAtivo.vue';
import DashCards from './components/DashCards.vue';
import BotoesFormula from './components/BotoesFormula.vue';


const app = createApp({});
app.component('Buscar', BuscarAtivo);
app.component('Dash', DashCards);
app.component('Botoes', BotoesFormula);
app.mount('#app');

