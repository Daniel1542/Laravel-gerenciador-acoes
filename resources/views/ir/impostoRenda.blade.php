@extends('layouts.mainDashboard')
@section('title', 'Imposto de renda')
@section('content')

<section class="secao_ir">
  <div class="container-total">
    <h1>Imposto de renda</h1>
    <div class="container">
      <form action="{{ route('imposto.opcoes') }}" method="GET">
        {{ csrf_field() }}
        <div class="formulario">
          <div class="row mb-4 justify-content-center">
            <div class="col-md-4">
              <label for="data" class="form-label">Data:</label>
              <select class="form-select" id="data" name="data" required>
                <?php
                $anoAtual = date('Y');
                $anosParaExibir = 20;
        
                for ($i = $anoAtual; $i >= $anoAtual - $anosParaExibir; $i--) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
              </select>
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
          </div>
          <div class="mb-1">
            <button type="submit" class="btn btn-custom">Baixar</button>
          </div>
        </div> 
      </form>
    </div>
    <div class="container2">
      <form action="{{ route('imposto.index') }}" method="GET">
        {{ csrf_field() }}
        <div class="formulario2">
          <div class="container justify-content-center">
            <div class="col-md-5 mx-auto" id="procura">
              <label for="data" class="form-label">Procurar por ano:</label>
              <select class="form-select" id="data" name="data" required>
                <?php
                $anoAtual = date('Y');
                $anosParaExibir = 20;
        
                for ($i = $anoAtual; $i >= $anoAtual - $anosParaExibir; $i--) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
              </select>
            </div> 
            <div class="mt-4">
              <button type="submit" class="btn btn-custom">Buscar</button>
            </div>  
            <div class="mt-4">
              <tr>
                <th id="anoSelecionado"></th>         
              </tr>
            </div>
          </div>
        </div>           
      </form>
    </div>
  </div>
</section>
<section class="secao_ir2">
  <div class="container" id="caixa">
    <div class="row justify-content-center">
      <div class="col-md-6 text-center">
        <h1 class="mt-4 mb-4">Ações</h1>
      </div>
    </div>
    <div class="div_container">
      <table class="table">
        <thead>
          <tr>
            <th>Bens e Direitos </th>         
          </tr>
          <tr>
            <th>Código: 31 — Ações</th>
          </tr>    
        </thead>
        <tbody class="table_body">
          @foreach ($dadosAtivos as $ativo)
            @if ($ativo['compra']['quantidadeTotal'] == 1 && $ativo['compra']['total'] > 0)
              <tr>
                <td> Compra de {{ $ativo['compra']['quantidadeTotal'] }} ação de {{ $ativo['nome'] }}, custo total R${{number_format ($ativo['compra']['total'], 2) }}.</td>    
              </tr>
            @endif
            @if ($ativo['compra']['quantidadeTotal'] > 1 && $ativo['compra']['total'] > 0)
              <tr>
                <td> Compra de {{ $ativo['compra']['quantidadeTotal'] }} ações de {{ $ativo['nome'] }}, custo total R${{number_format ($ativo['compra']['total'], 2) }}.</td>    
              </tr>
            @endif
          @endforeach
          @foreach ($dadosAtivos as $ativo)
            @if ($ativo['venda']['quantidadeTotal'] == 1 && $ativo['venda']['total'] > 0)
              <tr>
                <td> venda de {{ $ativo['venda']['quantidadeTotal'] }} ação de {{ $ativo['nome'] }}, custo total R${{number_format ($ativo['venda']['total'], 2) }}.</td>    
              </tr>
            @endif
            @if ($ativo['venda']['quantidadeTotal'] > 1 && $ativo['venda']['total'] > 0)
              <tr>
                <td> Venda de {{ $ativo['venda']['quantidadeTotal'] }} ações de {{ $ativo['nome'] }}, custo total R${{ number_format($ativo['venda']['total'], 2) }}.</td>
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
    <div class="row justify-content-center">
      <div class="col-md-6 text-center">
        <h1 class="mt-4 mb-4">Fiis</h1>
      </div>
    </div>
    <div class="div_container">
      <table class="table">
        <thead>
          <tr>
            <th>Bens e Direitos </th>         
          </tr>
          <tr>
            <th>Código: 07 – Fundos</th>
          </tr> 
          <tr>
            <th>Código: 03 – Fundos Imobiliários (FIIs)</th>
          </tr>          
        </thead>
        <tbody class="table_body"> 
          @foreach ($dadosfiis as $fiis)
            @if ($fiis['compra']['quantidadeTotal'] == 1 && $fiis['compra']['total'] > 0)
              <tr>
                <td> Compra de {{ $fiis['compra']['quantidadeTotal'] }} fundo imobiliário {{ $fiis['nome'] }}, custo total R$ {{number_format ($fiis['compra']['total'], 2) }}.</td>    
              </tr>
            @endif
            @if ($fiis['compra']['quantidadeTotal'] > 1 && $fiis['compra']['total'] > 0)
              <tr>
                <td> Compra de {{ $fiis['compra']['quantidadeTotal'] }} fundos imobiliários {{ $fiis['nome'] }}, custo total R$ {{number_format ($fiis['compra']['total'], 2) }}.</td>    
              </tr>              
            @endif
          @endforeach    
          @foreach ($dadosfiis as $fiis)
            @if ($fiis['venda']['quantidadeTotal'] == 1 && $fiis['venda']['total'] > 0)
              <tr>
                <td> venda de {{ $fiis['venda']['quantidadeTotal'] }} fundo imobiliário {{ $fiis['nome'] }}, custo total R$ {{number_format ($fiis['venda']['total'], 2) }}.</td>    
              </tr>
            @endif
            @if ($fiis['venda']['quantidadeTotal'] > 1 && $fiis['venda']['total'] > 0)
              <tr>
                <td> Venda de {{ $fiis['venda']['quantidadeTotal'] }} fundos imobiliários {{ $fiis['nome'] }}, custo total R$ {{number_format ($fiis['venda']['total'], 2) }}.</td>    
              </tr>
            @endif
          @endforeach  
        </tbody>
      </table>
    </div>  
  </div>
</section>

@endsection
