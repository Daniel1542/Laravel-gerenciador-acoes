import './bootstrap';
import { createApp } from 'vue';
import BuscarAtivo from './components/BuscarAtivo.vue';
import BotoesFormula from './components/BotoesFormula.vue';
import DashCards from './components/DashCards.vue';


const app = createApp({});
app.component('Botoes', BotoesFormula);
app.component('Buscar', BuscarAtivo);
app.component('Dash', DashCards);
app.mount('#app');