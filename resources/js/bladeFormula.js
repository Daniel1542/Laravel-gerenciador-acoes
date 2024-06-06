import './bootstrap';
import { createApp } from 'vue';
import TableRowFormula from './components/TableRowFormula.vue';

function initBladeFormula() {
  console.log('Inicializando o bladeFormula...');
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
  
    app.component('Tablerow', TableRowFormula);
    app.mount('#app2');
});

export default initBladeFormula;