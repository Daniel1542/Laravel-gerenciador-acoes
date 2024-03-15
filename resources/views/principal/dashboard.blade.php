@extends('layouts.maindashboard')
@section('title', 'Dashboard')
@section('content')

<section class="secao_dash">
    <div class="container">
        <div class="row" id="caixa">
            <h1 class="text-center">Quantidade</h1>
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
    <div id="caixa2">
        <h1 class="text-center">Porcentagem por ativo</h1>
        <div>
            <canvas id="graficoPizza"></canvas> 
        </div>       
    </div>
</section>

<script src="js/graficos.js"></script>
  
@endsection
