import './bootstrap';
import { createApp } from 'vue';
import TableRowFormula from './components/TableRowFormula.vue';

const app = createApp({
  data() {
    return {
      dadosBazin: JSON.parse(document.getElementById('app2').dataset.dadosBazin)
    };
  }
});

app.component('TableRow', TableRowFormula);
app.mount('#app2');
