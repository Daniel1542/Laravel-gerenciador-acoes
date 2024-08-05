<template>
    <div class="modal-content-add-ativo">
      <div class="container" id="caixa">
        <span class="close">&times;</span>
        <h1 class="mb-2 text-center">Cadastrar</h1>
        <form :action="`/ativos`" method="POST">
            <input type="hidden" name="_token" :value="csrfToken"/>
            <div class="form-group">
                <label for="tipo">Tipo de ativo:</label>
                <select id="tipo" name="tipo" required>
                    <option value="fundo imobiliario">fundo imobiliario</option>
                    <option value="acao">acao</option>
                </select>
            </div>
            <div class="form-group">
                <label for="movimento">Tipo de Operação:</label>
                <select id="movimento" name="movimento" required>
                    <option value="compra">compra</option>
                    <option value="venda">venda</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nome">Ativo:</label>
                <input type="text" id="nome" name="nome" oninput="this.value = this.value.toUpperCase()" required>
            </div>
            <div class="form-group">
                <label for="data">Data:</label>
                <input type="date" id="data" name="data" required>
            </div>
            <div class="form-group"> 
                <label for="corretagem">Corretagem:</label>
                <input type="number" id="corretagem" name="corretagem" required>
            </div>
            <div class="form-group"> 
                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade" required>
            </div>
            <div class="form-group">
                <label for="valor">Valor:</label>
                <input type="number" step="0.01" id="valor" name="valor" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
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
    const addAtivoBtn = document.getElementById('addAtivoBtn');   
    const addAtivoBtn2 = document.getElementById('addAtivoBtn2');  
    const modal = document.getElementById('modalAddAtivos');

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
  
    addAtivoBtn.addEventListener('click', openModal);
    addAtivoBtn2.addEventListener('click', openModal);
  
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