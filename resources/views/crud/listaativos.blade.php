@extends('layouts.maindashboard')
@section('title', 'Lista de ativos')
@section('content')

<section class="secao_ativos">
  <div class="container" id="caixa">
    <h1 class="text-center mb-4">Ações</h1>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Ação:</th>
            <th>Quantidade:</th>
            <th>Preço Médio:</th>     
            <th>Total:</th>
            <th>Porcentagem:</th>                 
          </tr>
        </thead>
        <tbody>
          @foreach($dadosAcoes as $acao)  
            @if ($acao['quantidadeTotal'] > 0) 
              <tr>
                <td> {{ $acao['nome'] }}</td>
                <td> {{ $acao['quantidadeTotal'] }}</td> 
                <td> R$ {{ number_format($acao['precoMedio'], 2) }}</td>
                <td> R$ {{ number_format ($acao['valorTotal'], 2) }}</td>
                <td> {{ number_format ($acao['porcentagem'], 2) }} %</td>     
              </tr> 
            @endif
          @endforeach   
        </tbody>
      </table>
    </div>
  </div>
</section>
<section class="secao_ativos2">
  <div class="container" id="caixa2">
    <h1 class="text-center mb-4">Fiis</h1>  
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Fundo imobiliário:</th>
            <th>Quantidade:</th>
            <th>Preço Médio:</th>   
            <th>Total:</th>    
            <th>Porcentagem:</th>                                          
          </tr>
        </thead>
        <tbody>
          @foreach($dadosfiis as $fii)    
            @if ($fii['quantidadeTotal'] > 0)      
              <tr>
                <td> {{ $fii['nome'] }}</td>           
                <td> {{ $fii['quantidadeTotal'] }}</td> 
                <td> R$ {{ number_format ($fii['precoMedio'], 2) }}</td>    
                <td> R$ {{ number_format ($fii['valorTotal'], 2) }}</td>     
                <td> {{ number_format ($fii['porcentagem'], 2) }} %</td>     
              </tr> 
            @endif
          @endforeach    
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
