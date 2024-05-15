@extends('layouts.mainDashboard')
@section('title', 'Fórmulas')
@section('content')

<section class="secao_formula">
  <div class="container">
    <h1 class="mt-4 mb-4 text-center">Fórmulas</h1>
    {{-- botões para cadastro de fórmulas --}}
    <div class="opcoes">
      <div class="opcoes_formulas">
        <label for="Bazin">Formula de Bazin</label>
        <button id="bazinBtn" class="btn btn-custom">Adicionar</button>
      </div>
      <div class="opcoes_formulas">
        <label for="Graham">Formula de Graham</label>
        <button id="GrahamBtn" class="btn btn-custom">Adicionar</button>
      </div>
    </div> 
    {{-- Formulário para cadastro de Graham --}}
    <div class="form_graham">
      <form action="{{ route('formula.createGraham') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="container" id="caixa_1">
          <h1 class="mt-4 mb-4">Fórmula de Graham</h1>
          <div class="opcoes">
            <div class="col-md-3">
              <label for="ticker" class="form-label">ticker:</label>
              <input type="text" class="form-control" id="ticker" name="ticker" oninput="this.value = this.value.toUpperCase()" required>
            </div>
            <div class="col-md-3">
              <label for="lpa" class="form-label">LPA:</label>
              <input type="text" class="form-control" id="lpa" name="lpa" required>
            </div>
            <div class="col-md-3">
              <label for="vpa" class="form-label">VPA:</label>
              <input type="text" class="form-control" id="vpa" name="vpa" required>
            </div>
          </div>
          <div>
            <button type="submit" class="btn btn-custom">Salvar</button>
          </div>
        </div>
      </form>  
    </div>
  </div>
</section>
{{-- Seção para tabela de Bazin --}}
<section class="secao_formula_2">
  <div class="container" id="caixa_2">
    <h1 class="mt-2 mb-4">Bazin</h1>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>   
            <th>Ticker:</th>
            <th>DPA:</th>   
            <th>Dividend yield:</th> 
            <th>Preço teto:</th> 
            <th>Opções:</th>             
          </tr>
        </thead>
        <tbody>
          @foreach($dadosBazin as $bazin)     
            <tr>
              <td>{{ $bazin['ticker'] }}</td>     
              <td>{{ $bazin['dpa'] }}</td>
              <td>{{ $bazin['dividend_yield'] }} %</td>
              <td>R$ {{number_format ($bazin['preco_teto'], 2) }}</td>
              <td class="buttons"> 
                <form action="{{ route('formula.editBazin', ['id' => $bazin['id']]) }}" method="GET">
                  {{ csrf_field() }}
                  <button type="submit" class="btn btn-warning">Editar</button>
                </form>
                <form action="{{ route('formula.destroyBazin', ['id' => $bazin['id']]) }}" method="POST">
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
{{-- Seção para tabela de Graham --}}
<section class="secao_formula_2">
  <div class="container" id="caixa_3">
    <h1 class="mt-2 mb-4">Graham</h1>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Ticker:</th>
            <th>LPA:</th>   
            <th>VPA:</th> 
            <th>Preço justo:</th> 
            <th>Opções:</th>                  
          </tr>
        </thead>
        <tbody>
          @foreach($dadosGraham as $graham) 
            <tr>
              <td> {{ $graham['ticker'] }}</td>    
              <td> {{ $graham['lpa'] }}</td>
              <td> {{ $graham['vpa'] }}</td>
              <td>R$ {{number_format ($graham['preco_justo'], 2) }}</td>
              <td class="buttons">    
                <form action="{{ route('formula.editGraham', ['id' => $graham['id']]) }}" method="GET">
                  {{ csrf_field() }}
                  <button type="submit" class="btn btn-warning">Editar</button>
                </form>
                <form action="{{ route('formula.destroyGraham', ['id' => $graham['id']]) }}" method="POST">
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
