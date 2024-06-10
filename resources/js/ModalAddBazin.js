import './bootstrap';
import { createApp } from 'vue';
import ModalAddBazin from './components/ModalAddBazin.vue';

function initModalAddBazin() {
  console.log('Inicializando o Vue ModalAddBazin...');
}

document.addEventListener('DOMContentLoaded', () => {
    const appElement = document.getElementById('modalAddBazin');
    const app = createApp({});
    app.component('Modalbazin', ModalAddBazin);
    app.mount('#modalAddBazin');
    
});

export default initModalAddBazin;