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
  this.createChart('/graficoAcoes', 'graficoPizza');
  this.createChart('/graficoFiis', 'graficoPizza2');
  this.createChart('/graficoTotal', 'graficoPizza3');
  },
  methods: {
    createChart(url, canvasId) {
      fetch(url)
        .then(response => response.json())
        .then(data => {
          var ctx = document.getElementById(canvasId).getContext('2d');
          var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
              labels: data.labels,
              datasets: [{
                data: data.datasets[0].data,
                backgroundColor: data.datasets[0].backgroundColor,
                borderColor: data.datasets[0].borderColor,
                borderWidth: 1
              }]
            },
            options: {
              plugins: {
                legend: {
                  display: false,
                },
                labels: {
                  color: 'white'
                },
                tooltip: {
                  callbacks: {
                    label: function (context) {
                      const label = context.label || '';
                      const value = context.raw || 0;
                      return `R$ ${value}`;
                    }
                  }
                }
              }
            }
          });
        })
        .catch(error => {
          console.error('Erro ao buscar dados do gráfico:', error);
        });
    }
  }
}
</script>
  