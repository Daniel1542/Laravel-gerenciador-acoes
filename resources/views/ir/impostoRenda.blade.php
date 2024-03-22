@extends('layouts.maindashboard')
@section('title', 'Imposto de renda')
@section('content')

<section class="secao_ir">
  <div class="container-total">
    <h1>Imposto de renda</h1>
    <form class="formulario" action="{{ route('imposto.opcoes') }}" method="GET">
      {{ csrf_field() }}
      <div class="col-md-4">
        <label for="data_inicio" class="form-label">Data Início:</label>
        <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
      </div>
      <div class="col-md-4">
        <label for="data_fim" class="form-label">Data Fim:</label>
        <input type="date" class="form-control" id="data_fim" name="data_fim" required>
      </div>
      <div class="col-md-4">
        <label for="tipo" class="form-label">Tipo:</label>
        <select class="form-select" id="tipo" name="tipo" required>
          <option value="acao">Ação</option>
          <option value="fundo imobiliario">Fundo Imobiliário</option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="baixar" class="form-label">Baixar:</label>
        <select class="form-select" id="baixar" name="baixar" required>
          <option value="PDF">PDF</option>
          <option value="Excel">Excel</option>
        </select>
      </div>
      <div class="mb-1">
        <button type="submit" class="btn btn-custom mb-1">Baixar</button>
      </div>
    </form>
  </div>
</section>
<section class="secao_ir2">
  <div class="container" id="caixa">      
    <h1 class="mt-4 mb-4 text-center">Ações</h1>       
    <div class="table-responsive">
      <table class="table">
        <tbody>
          @foreach ($dadosAtivos as $ativo)
            @if ($ativo['compra']['quantidadeTotal'] == 1 && $ativo['compra']['total'] > 0)
              <tr>
                <td> Compra de {{ $ativo['compra']['quantidadeTotal'] }} ação de {{ $ativo['nome'] }}, custo total {{number_format ($ativo['compra']['total'], 2) }} reais.</td>    
              </tr>
            @endif
            @if ($ativo['compra']['quantidadeTotal'] > 1 && $ativo['compra']['total'] > 0)
              <tr>
                <td> Compra de {{ $ativo['compra']['quantidadeTotal'] }} ações de {{ $ativo['nome'] }}, custo total {{number_format ($ativo['compra']['total'], 2) }} reais.</td>    
              </tr>
            @endif
          @endforeach
          @foreach ($dadosAtivos as $ativo)
            @if ($ativo['venda']['quantidadeTotal'] == 1 && $ativo['compra']['total'] > 0)
              <tr>
                <td> Venda de {{ $ativo['venda']['quantidadeTotal'] }} ação de {{ $ativo['nome'] }}, custo total {{number_format ($ativo['venda']['total'], 2) }} reais.</td>    
              </tr>
            @endif
            @if ($ativo['venda']['quantidadeTotal'] > 0 && $ativo['venda']['total'] > 0)
              <tr>
                <td> Venda de {{ $ativo['venda']['quantidadeTotal'] }} ações de {{ $ativo['nome'] }}, custo total {{ number_format($ativo['venda']['total'], 2) }} reais.</td>
              </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>  
  </div>
</section>
<section class="secao_ir3">
  <div class="container" id="caixa2">
    <h1 class="mt-4 mb-4 text-center">Fiis</h1>
    <div class="table-responsive">
      <table class="table">
        <tbody> 
          @foreach ($dadosfiis as $fiis)
            @if ($fiis['compra']['quantidadeTotal'] == 1 && $fiis['compra']['total'] > 0)
              <tr>
                <td> Compra de {{ $fiis['compra']['quantidadeTotal'] }} fundo imobiliário {{ $fiis['nome'] }}, custo total {{number_format ($fiis['compra']['total'], 2) }} reais.</td>    
              </tr>
            @endif
            @if ($fiis['compra']['quantidadeTotal'] > 0 && $fiis['compra']['total'] > 0)
              <tr>
                <td> Compra de {{ $fiis['compra']['quantidadeTotal'] }} fundos imobiliários {{ $fiis['nome'] }}, custo total {{number_format ($fiis['compra']['total'], 2) }} reais.</td>    
              </tr>
            @endif
          @endforeach    
          @foreach ($dadosfiis as $fiis)
            @if ($fiis['venda']['quantidadeTotal'] == 1 && $fiis['venda']['total'] > 0)
              <tr>
                <td> Venda de {{ $fiis['venda']['quantidadeTotal'] }} fundo imobiliário {{ $fiis['nome'] }}, custo total {{number_format ($fiis['venda']['total'], 2) }} reais.</td>    
              </tr>
            @endif
            @if ($fiis['venda']['quantidadeTotal'] > 0 && $fiis['venda']['total'] > 0)
              <tr>
                <td> Venda de {{ $fiis['venda']['quantidadeTotal'] }} fundos imobiliários {{ $fiis['nome'] }}, custo total {{number_format ($fiis['venda']['total'], 2) }} reais.</td>    
              </tr>
            @endif
          @endforeach  
        </tbody>
      </table>
    </div>  
  </div>
</section>
@endsection
