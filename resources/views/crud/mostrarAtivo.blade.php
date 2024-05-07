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
            <th>Nome:</th>
            <th>Movimento</th>   
            <th>Quantidade: </th>
            <th>Valor: </th>       
            <th>Corretagem: </th>
            <th>Valor total: </th>    
            <th>Data: </th>          
          </tr>
        </thead>
        <tbody>
          @foreach($dadosAtivos as $ativos)
            <tr>
              <td> {{ $ativos['nome'] }}</td>
              <td> {{ $ativos['movimento'] }}</td> 
              <td> {{ $ativos['quantidade']}}</td>         
              <td>R$ {{ number_format($ativos['valor'], 2) }}</td>
              <td>R$ {{ number_format($ativos['corretagem'], 2) }}</td>
              <td>R$ {{ number_format($ativos['valorFinal'], 2) }}</td>
              <td> {{ $ativos['data']}}</td>                     
            </tr> 
          @endforeach    
        </tbody>         
      </table>
    </div>
  </div>
</section>
@endsection