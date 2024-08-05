import './bootstrap';
import { createApp } from 'vue';
import ModalAddAtivos from './components/ModalAddAtivos.vue';

function initModalAddAtivos() {
  console.log('Inicializando o Vue ModalAddAtivos...');
}

document.addEventListener('DOMContentLoaded', () => {
    const appElement = document.getElementById('modalAddAtivos');
    const app = createApp({});
    app.component('Modalativos', ModalAddAtivos);
    app.mount('#modalAddAtivos');
    
});

export default initModalAddAtivos;