document.addEventListener('DOMContentLoaded', function() {
    // Selecione os botões para abrir o modal
    var bazinBtn = document.getElementById('bazinBtn');
  
    // Selecione o modal
    var modal = document.getElementById('modalAddBazin');
  
    // Selecione o elemento span dentro do modal para fechar o modal
    var spanCloseModal = modal.querySelector('.close');
  
    // Função para abrir o modal
    function openModal() {
      modal.style.display = 'block'; // Mostra o modal
    }
  
    // Função para fechar o modal
    function closeModal() {
      modal.style.display = 'none'; // Esconde o modal
    }
  
    // Quando o usuário clicar no botão, abra o modal
    bazinBtn.addEventListener('click', openModal);
  
    // Quando o usuário clicar no span (x), feche o modal
    spanCloseModal.addEventListener('click', closeModal);
  
    // Quando o usuário clicar em qualquer lugar fora do modal, feche-o
    window.addEventListener('click', function(event) {
      if (event.target == modal) {
        closeModal();
      }
    });
  });
  