document.addEventListener('DOMContentLoaded', function() {
    // Selecione o botão para abrir o modal
    var btn = document.getElementById('myBtn');
  
    // Selecione o modal
    var modal = document.getElementById('myModal');
  
    // Quando o usuário clicar no botão
    btn.addEventListener('click', function() {
      modal.style.display = 'block'; // Mostra o modal
    });
  
    // Selecione o elemento span dentro do modal para fechar o modal
    var span = document.getElementsByClassName('close')[0];
  
    // Quando o usuário clicar no span (x), feche o modal
    span.addEventListener('click', function() {
      modal.style.display = 'none'; // Esconde o modal
    });
  
    // Quando o usuário clicar em qualquer lugar fora do modal, feche-o
    window.addEventListener('click', function(event) {
      if (event.target == modal) {
        modal.style.display = 'none'; // Esconde o modal
      }
    });
  });
  