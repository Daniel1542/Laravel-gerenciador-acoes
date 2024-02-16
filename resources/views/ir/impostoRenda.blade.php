@extends('layouts.maindashboard')
@section('title', 'Imposto de renda')
@section('content')

  <section class="secao_ir">
    <div class="container text-center">
      <h1>Imposto de renda</h1>
      <div class="container mt-4">
        <form class="formulario" action="{{ route('imposto.exportAtivos') }}" method="GET">
          {{ csrf_field() }}
          <div class="row mb-3">
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
          </div>
          <div class="mb-3">
            <button type="submit" class="btn btn-custom mb-2 mx-2">Baixar Excel</button>
            <a class="btn btn-custom mb-2 mx-2" href="{{ route('imposto.exportIrpdfPdf', ['data_inicio' => request('data_inicio'), 'data_fim' => request('data_fim'), 'tipo' => request('tipo')]) }}">Baixar PDF de todos ativos</a>
          </div>
        </form>
      </div>
    </div>
    <!-- Tabela para listar -->
    <div class="container" id="caixa">
      <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h1 class="mt-4" style="margin-bottom:20px;">Ações</h1>
        </div>
      </div>
      <div class="div_container">
        <table class="table">
          <tbody class="table_body">
            @foreach ($dadosAtivos as $ativo)
              @if (isset($ativo['compra']['quantidadeTotal']) && $ativo['compra']['quantidadeTotal'] > 0)
                <tr>
                  <td> Compra de {{ $ativo['compra']['quantidadeTotal'] }} ações de {{ $ativo['nome'] }}, custo total {{number_format ($ativo['compra']['total'], 2) }} reais.</td>    
                </tr>
              @endif
            @endforeach
            @foreach ($dadosAtivos as $ativo)
              @if (isset($ativo['venda']['quantidadeTotal']) && $ativo['venda']['quantidadeTotal'] > 0)
                <tr>
                  <td> Venda de {{ $ativo['venda']['quantidadeTotal'] }} ações de {{ $ativo['nome'] }}, custo total {{ number_format($ativo['venda']['total'], 2) }} reais.</td>
                </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>  
    </div>
    <div class="container" id="caixa2">
      <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h1 class="mt-4" style="margin-bottom:20px;">Fiis</h1>
        </div>
      </div>
      <div class="div_container">
        <table class="table">
          <tbody class="table_body"> 
            @foreach ($dadosfiis as $fiis)
              @if (isset($fiis['compra']['quantidadeTotal']) && $fiis['compra']['quantidadeTotal'] > 0)
                <tr>
                  <td> Compra de {{ $fiis['compra']['quantidadeTotal'] }} fundos imobiliários de {{ $fiis['nome'] }}, custo total {{number_format ($fiis['compra']['total'], 2) }} reais.</td>    
                </tr>
              @endif
            @endforeach    
            @foreach ($dadosfiis as $fiis)
              @if (isset($fiis['venda']['quantidadeTotal']) && $fiis['venda']['quantidadeTotal'] > 0)
                <tr>
                  <td> Venda de {{ $fiis['venda']['quantidadeTotal'] }} fundos imobiliários de {{ $fiis['nome'] }}, custo total {{number_format ($fiis['venda']['total'], 2) }} reais.</td>    
                </tr>
              @endif
            @endforeach  
          </tbody>
        </table>
      </div>  
    </div>
  </section>
@endsection
