import './bootstrap';
import { createApp } from 'vue';
import TableRowFormulaGraham from './components/TableRowFormulaGraham.vue';

function initFormulaGraham() {
  console.log('Inicializando o Vue FormulaGraham...');
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

export default initFormulaGraham;