import './bootstrap';
import { createApp } from 'vue';
import TableRowFormulaBazin from './components/TableRowFormulaBazin.vue';

function initFormulaBazin() {
  console.log('Inicializando o  Vue FormulaBazin...');
}

document.addEventListener('DOMContentLoaded', () => {
    const appElement = document.getElementById('app2');
    const dadosBazin = JSON.parse(appElement.dataset.dadosBazin);
  
    const app = createApp({
      data() {
        return {
          dadosBazin
        };
      }
    });
  
    app.component('Tablebazin', TableRowFormulaBazin);
    app.mount('#app2');
});

export default initFormulaBazin;