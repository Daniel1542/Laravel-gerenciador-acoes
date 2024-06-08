import './bootstrap';
import { createApp } from 'vue';
import BuscarAtivo from './components/BuscaAtivo.vue';

function initBuscaAtivo() {
  console.log('Inicializando o Vue BuscarAtivo...');
}

document.addEventListener('DOMContentLoaded', () => {
    const appElement = document.getElementById('busca_ativo');
    const app = createApp({});
    app.component('Buscaativo', BuscarAtivo);
    app.mount('#busca_ativo');
    
});

export default initBuscaAtivo;