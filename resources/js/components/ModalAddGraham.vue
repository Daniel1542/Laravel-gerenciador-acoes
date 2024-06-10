<template>
    <div class="modal-content-add-formula">   
        <div class="container" id="caixa_1">
          <span class="close">&times;</span>
          <h1 class="mt-4 mb-4 text-center">Fórmula de Graham</h1>
          <form :action="`/criar-graham`" method="POST">
            <input type="hidden" name="_token" :value="csrfToken"/>
            <div class="opcoes">
              <div class="col-md-3">
                <label for="ticker" class="form-label">Ticker:</label>
                <input type="text" class="form-control" id="ticker" name="ticker" oninput="this.value = this.value.toUpperCase()" required>
              </div>
              <div class="col-md-3">
                <label for="lpa" class="form-label">LPA:</label>
                <input type="text" class="form-control" id="lpa" name="lpa" required>
              </div>
              <div class="col-md-3">
                <label for="vpa" class="form-label">VPA:</label>
                <input type="text" class="form-control" id="vpa" name="vpa" required>
              </div>
            </div>
            <div class="button">
              <button type="submit" class="btn btn-custom">Salvar</button>
            </div>        
          </form> 
        </div> 
    </div>
</template>

<script>
export default {
  data() {
    return {
      csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    };
  },
  mounted() {
    // Selecione os botões para abrir o modal
    const grahamBtn = document.getElementById('grahamBtn');
  
    // Selecione o modal
    const modal = document.getElementById('modalAddGraham');
  
    // Selecione o elemento span dentro do modal para fechar o modal
    const spanCloseModal = modal.querySelector('.close');
  
    // Função para abrir o modal
    function openModal() {
      modal.style.display = 'block'; // Mostra o modal
    }
  
    // Função para fechar o modal
    function closeModal() {
      modal.style.display = 'none'; // Esconde o modal
    }
  
    // Quando o usuário clicar no botão, abra o modal
    grahamBtn.addEventListener('click', openModal);
  
    // Quando o usuário clicar no span (x), feche o modal
    spanCloseModal.addEventListener('click', closeModal);
  
    // Quando o usuário clicar em qualquer lugar fora do modal, feche-o
    window.addEventListener('click', function(event) {
      if (event.target == modal) {
        closeModal();
      }
    });
  },
  methods: {
    toUpperCase(event) {
      event.target.value = event.target.value.toUpperCase();
    }
  }
};
</script>