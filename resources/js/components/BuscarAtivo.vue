 <!-- Formulário para buscar ativo -->
<template>
  <div class="formulario1">
    <label for="Nome">Nome:</label>
    <div class="autocomplete">
      <input type="text" id="Nome" name="Nome" autocomplete="off">
      <ul id="suggestions"></ul>
    </div>
    <button class="btn btn-primary" type="submit">Buscar</button>
  </div> 
</template>

<script>
  export default {
    mounted() {
      console.log('Component mounted.')
    }
  }
</script>
