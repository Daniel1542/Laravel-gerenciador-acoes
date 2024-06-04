 <!-- botões para cadastro de fórmulas -->
 <template>
    <div class="opcoes">
      <div class="opcoes_formulas">
        <label for="Bazin">Formula de Bazin</label>
        <button id="bazinBtn" class="btn btn-custom">Adicionar</button>
      </div>
      <div class="opcoes_formulas">
        <label for="Graham">Formula de Graham</label>
        <button id="grahamBtn" class="btn btn-custom">Adicionar</button>
      </div>
    </div> 
  </template>
  
  <script>
    export default {
      mounted() {
        console.log('Component mounted.')
      }
    }
  </script>
  