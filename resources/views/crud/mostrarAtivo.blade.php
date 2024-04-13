@extends('layouts.mainDashboard')
@section('title','Ativos')
@section('content')

<section class='secao_mostrar'>
  <div class="container" id="caixa">
    <div class="row justify-content-center">
      <div class="col-md-6 text-center">
        <h1 class="mt-2 mb-2">Ativos</h1>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>   
            <th>Ação:</th>
            <th>Movimento</th>   
            <th>Quantidade: </th>
            <th>Valor: </th>       
            <th>Corretagem: </th>
            <th>Data: </th>        
          </tr>
        </thead>
        <tbody>
          @foreach($dadosAtivos as $acao)
            <tr>
              <td> {{ $acao['nome'] }}</td>
              <td> {{ $acao['movimento'] }}</td> 
              <td> {{ $acao['quantidade']}}</td>         
              <td>R$ {{ number_format($acao['valor'], 2) }}</td>
              <td>R$ {{ number_format($acao['corretagem'], 2) }}</td>
              <td> {{ $acao['data']}}</td>                     
            </tr> 
          @endforeach    
        </tbody>         
      </table>
    </div>
  </div>
</section>
@endsection