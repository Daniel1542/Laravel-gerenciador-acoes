@extends('layouts.mainDashboard')
@section('title', 'Movimentações')
@section('content')

{{-- Seção para buscar ativo --}}
<section class="secao_movimento">
  <div class="container text-center">
    <h1 class="mt-4 mb-4">Buscar ativo</h1>
    <div id="busca_ativo" class="container mb-4">     
      {{-- Vue de formulário para buscar ativo --}}
      <Buscaativo></Buscaativo>
    </div> 
    <div class="container mt-4">
      {{-- Formulário para baixar opções de movimento --}}
      <form action="{{ route('movimento.opcoesmove') }}" method="GET">
        {{ csrf_field() }}
        <div class="formulario2">    
          <div class="row mb-1">
            <div class="col-md-3 mb-3">
              <label for="data_inicio" class="form-label">Data Início:</label>
              <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
            </div>
            <div class="col-md-3 mb-3">
              <label for="data_fim" class="form-label">Data Fim:</label>
              <input type="date" class="form-control" id="data_fim" name="data_fim" required>
            </div>
            <div class="col-md-3 mb-3">
              <label for="tipo" class="form-label">Tipo:</label>
              <select class="form-select" id="tipo" name="tipo" required>
                <option value="acao">Ação</option>
                <option value="fundo imobiliario">Fundo Imobiliário</option>
              </select>
            </div>
            <div class="col-md-3 mb-3">
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
  </div>
  {{-- Vue para cadastrar ativo --}}
  <div id="modalAddAtivos" class="modal">
    <Modalativos></Modalativos>
  </div>
</section>
{{-- Seção para mostrar ações --}}
<section class="secao_movimento_1">
  <div class="container" id="caixa"> 
    <div class="text-center mb-4 mt-2">
      <h1>Ações</h1>
      <button id="addAtivoBtn" class="btn btn-primary mt-2">Compra e venda</button>
    </div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>   
            <th>Ação:</th>
            <th>Movimento:</th>   
            <th>Quantidade:</th>
            <th>Valor investido:</th>       
            <th>Corretagem:</th>
            <th>Total:</th>
            <th>Data:</th>   
            <th>Opções:</th>         
          </tr>
        </thead>
        <tbody>
          {{-- Loop dados de ações --}}
          @foreach($dadosAcoes as $acao)     
            <tr>
              <td> {{ $acao['nome'] }}</td>
              <td> {{ $acao['movimento'] }}</td> 
              <td> {{ $acao['quantidade'] }}</td>         
              <td>R$ {{ number_format($acao['valor'], 2) }}</td>
              <td>R$ {{ number_format($acao['corretagem'], 2) }}</td>
              <td>R$ {{ number_format($acao['valor_total'], 2) }}</td>
              <td> {{ $acao['data'] }}</td>     
              <td class="buttons">
                <form action="{{ route('ativos.edit', ['id' => $acao['id']]) }}" method="GET">
                  {{ csrf_field() }}
                  <button type="submit" class="btn btn-warning">Editar</button>
                </form>
                <form action="{{ route('ativos.destroy', ['id' => $acao['id']]) }}" method="POST">
                  {{ csrf_field() }}
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                </form>              
              </td>                 
            </tr> 
          @endforeach  
        </tbody>              
      </table>
    </div>
  </div>
</section>
{{-- Seção para mostrar fiis --}}
<section class="secao_movimento_1">
  <div class="container" id="caixa2">
    <div class="text-center mb-4 mt-2">
      <h1>Fiis</h1>
      <button id="addAtivoBtn2" class="btn btn-primary mt-2">Compra e venda</button>
    </div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Fii:</th>
            <th>Movimento:</th>   
            <th>Quantidade:</th>
            <th>Valor investido:</th>       
            <th>Corretagem:</th>
            <th>Total:</th>
            <th>Data:</th>   
            <th>Opções:</th>     
          </tr>
        </thead>
        <tbody>
          {{-- Loop dados de FIIs --}}
          @foreach($dadosFiis as $fii) 
            <tr>
              <td> {{ $fii['nome'] }}</td>
              <td> {{ $fii['movimento'] }}</td> 
              <td> {{ $fii['quantidade'] }}</td>  
              <td>R$ {{ number_format($fii['valor'], 2) }}</td>
              <td>R$ {{ number_format($fii['corretagem'], 2) }}</td>
              <td>R$ {{ number_format($fii['valor_total'], 2) }}</td>
              <td> {{ $fii['data'] }}</td>           
              <td class="buttons">       
                <form action="{{ route('ativos.edit', ['id' => $fii['id']]) }}" method="GET">
                  {{ csrf_field() }}
                  <button type="submit" class="btn btn-warning">Editar</button>
                </form>
                <form action="{{ route('ativos.destroy', ['id' => $fii['id']]) }}" method="POST">
                  {{ csrf_field() }}
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                </form>              
              </td>                 
            </tr> 
          @endforeach    
        </tbody>   
      </table>
    </div>
  </div>
</section>

@endsection