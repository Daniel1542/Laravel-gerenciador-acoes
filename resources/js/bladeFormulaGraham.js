import './bootstrap';
import { createApp } from 'vue';
import TableRowFormulaGraham from './components/TableRowFormulaGraham.vue';

function initBladeFormulaGraham() {
  console.log('Inicializando o bladeFormulaGraham...');
}

document.addEventListener('DOMContentLoaded', () => {
    const appElement = document.getElementById('app3');
    const dadosGraham = JSON.parse(appElement.dataset.dadosGraham);
  
    const app = createApp({
      data() {
        return {
          dadosGraham
        };
      }
    });
  
    app.component('Tablegraham', TableRowFormulaGraham);
    app.mount('#app3');
});

export default initBladeFormulaGraham;