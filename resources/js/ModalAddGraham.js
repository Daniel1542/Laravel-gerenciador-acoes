import './bootstrap';
import { createApp } from 'vue';
import ModalAddGraham from './components/ModalAddGraham.vue';

function initModalAddGraham() {
  console.log('Inicializando o Vue ModalAddGraham...');
}

document.addEventListener('DOMContentLoaded', () => {
    const appElement = document.getElementById('modalAddGraham');
    const app = createApp({});
    app.component('Modalgraham', ModalAddGraham);
    app.mount('#modalAddGraham');
    
});

export default initModalAddGraham;