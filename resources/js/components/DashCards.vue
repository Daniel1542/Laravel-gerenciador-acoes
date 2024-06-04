 <!-- graficos pizza dashboard-->
<template>
   <div id="caixa2">
        <h1 class="text-center">Valor investido por ativo</h1>
        <div class="container">
            <div class="text-center">
                <h2>Ações</h2>
                <canvas id="graficoPizza"></canvas> 
            </div>  
            <div class="text-center">
                <h2>Fiis</h2>
                <canvas id="graficoPizza2"></canvas> 
            </div>
            <div class="text-center">
                <h2>Total</h2>
                <canvas id="graficoPizza3"></canvas> 
            </div>            
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
  