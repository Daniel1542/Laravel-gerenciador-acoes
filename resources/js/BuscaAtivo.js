import './bootstrap';
import { createApp } from 'vue';
import BuscaAtivo from './components/BuscaAtivo.vue';

function initBuscaAtivo() {
  console.log('Inicializando o Vue BuscaAtivo...');
}

document.addEventListener('DOMContentLoaded', () => {
    const appElement = document.getElementById('busca_ativo');
    const app = createApp({});
    app.component('Buscaativo', BuscaAtivo);
    app.mount('#busca_ativo');
    
});

export default initBuscaAtivo;