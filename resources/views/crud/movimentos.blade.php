@extends('layouts.mainDashboard')
@section('title', 'Movimentações')
@section('content')

{{-- Seção para buscar ativo --}}
<section class="secao_movimento">
  <div class="container text-center">
    <h1 class="mt-4 mb-4">Buscar ativo</h1>
    <div class="container mb-4">     
      {{-- Formulário para buscar ativo --}}
      <form action="{{ route('ativos.show')}}" method="GET">
        {{ csrf_field() }}
        <div id="app">
          <Buscar></Buscar>
        </div>
      </form>
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
  {{-- modal para cadastrar ativo --}}
  <div id="modalAddAtivo" class="modal">
    <div class="modal-content-add-ativo">
      <div class="container" id="caixa">
        <span class="close">&times;</span>
        <h1 class="mb-2 text-center">Cadastrar</h1>
        <form action="{{ route('ativos.store') }}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="tipo">Tipo de ativo:</label>
            <select id="tipo" name="tipo" required>
              <option value="fundo imobiliario">fundo imobiliario</option>
              <option value="acao">acao</option>
            </select>
          </div>
          <div class="form-group">
            <label for="movimento">Tipo de Operação:</label>
            <select id="movimento" name="movimento" required>
              <option value="compra">compra</option>
              <option value="venda">venda</option>
            </select>
          </div>
          <div class="form-group">
            <label for="nome">Ativo:</label>
            <input type="text" id="nome" name="nome" oninput="this.value = this.value.toUpperCase()" required>
          </div>
          <div class="form-group">
            <label for="data">Data:</label>
            <input type="date" id="data" name="data" required>
          </div>
          <div class="form-group"> 
            <label for="corretagem">Corretagem:</label>
            <input type="number" id="corretagem" name="corretagem" required>
          </div>
          <div class="form-group"> 
            <label for="quantidade">Quantidade:</label>
            <input type="number" id="quantidade" name="quantidade" required>
          </div>
          <div class="form-group">
            <label for="valor">Valor:</label>
            <input type="number" step="0.01" id="valor" name="valor" required>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Cadastrar</button>
          </div>  
        </form>
      </div>
    </div>
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

<script src="js/movimento_buscar_ativo.js"></script>
<script src="js/modal_add_ativos.js"></script>


@endsection
