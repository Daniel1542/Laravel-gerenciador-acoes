@extends('layouts.maindashboard')
@section('title', 'Dashboard')
@section('content')

<section class="secao_dash">
    <div class="container">
        <div class="row" id="caixa">
            <div class="col-md-6" id="organiza">
                <div class="card mt-3">   
                    <div class="card-body">
                        <div class="flex-column text-center">
                            <h5 class="card-title mb-3">Ações:</h5>
                            @if ($acoesCount > 0)
                                <p class="font">{{ $acoesCount }}</p>
                            @endif
                        </div>                                          
                    </div>
                </div>
                <div class="card mt-3">                      
                    <div class="card-body">
                        <div class="flex-column text-center">
                            <h5 class="card-title mb-3">FIIs:</h5>
                            @if ($fiisCount > 0)
                                <p class="font" >{{ $fiisCount }}</p>
                            @endif
                        </div>                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="secao_dash">
    <div class="container">
        <div class="row" id="caixa">
            <canvas id="graficoPizza"></canvas>
        </div>
    </div>
</section>


<script>
    document.addEventListener('DOMContentLoaded', function() {
    fetch('/grafico')
        .then(response => response.json())
        .then(data => {
            // Use os dados para criar o gráfico
            var ctx = document.getElementById('graficoPizza').getContext('2d');
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
                }
            });
        });
});

</script>
  
@endsection
