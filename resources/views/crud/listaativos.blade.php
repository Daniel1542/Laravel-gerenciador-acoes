@extends('layouts.maindashboard')
@section('title', 'Lista de ativos')
@section('content')

  <section class="secao_ativos">
    <div class="container" id="caixa">
      <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h1 class="mt-4" style="margin-bottom:20px;">Ações</h1>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table" >
          <thead>
            <tr>
              <th class="opcoes-a">Ação:</th>
              <th class="opcoes-a">Quantidade: </th>
              <th class="opcoes-a">Preço Médio: </th>               
            </tr>
          </thead>
          @foreach($dadosAcoes as $acao)  
            @if ($acao['quantidadeTotal'] > 0) 
              <tr>
                <td> {{ $acao['nome'] }}</td>
                <td> {{ $acao['quantidadeTotal'] }}</td> 
                <td> {{ number_format($acao['precoMedio'], 2) }}</td>                       
              </tr> 
            @endif
          @endforeach    
        </table>
      </div>
    </div>
    <div class="container" id="caixa2">
      <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h1 class="mt-4" style="margin-bottom:20px;">Fiis</h1>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table" >
          <thead>
            <tr>
              <th class="opcoes-a">Fundos imobiliarios:</th>
              <th class="opcoes-a">Quantidade: </th>
              <th class="opcoes-a">Preço Médio: </th>                     
            </tr>
          </thead>
          @foreach($dadosfiis as $fii)    
            @if ($fii['quantidadeTotal'] > 0)      
              <tr>
                <td> {{ $fii['nome'] }}</td>           
                <td> {{ $fii['quantidadeTotal'] }}</td> 
                <td> {{ number_format ($fii['precoMedio'], 2) }}</td>                         
              </tr> 
            @endif
          @endforeach    
        </table>
      </div>
    </div>
  </section>
@endsection
