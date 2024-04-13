@extends('layouts.mainDashboard')
@section('title', 'Fórmulas')
@section('content')

<section class="secao_formula">
  <div class="container">
    <h1 class="mt-4 mb-4 text-center">Fórmulas</h1>
    <form action="{{ route('formula.createBazin') }}" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="container" id="caixa">
        <h1 class="mt-4 mb-4">Fórmula de Bazin</h1>
        <div class="opcoes">
          <div class="col-md-3">
            <label for="nome" class="form-label">Nome do ativo:</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
          </div>
          <div class="col-md-3">
            <label for="dpa" class="form-label">DPA:</label>
            <input type="text" class="form-control" id="dpa" name="dpa" required>
          </div>
          <div class="col-md-3">
            <label for="dividend_yield" class="form-label">Dividend yield:</label>
            <input type="text" class="form-control" id="dividend_yield" name="dividend_yield" required>
          </div>
        </div>
        <div>
          <button type="submit" class="btn btn-custom">Salvar</button>
        </div>
      </div>
    </form>
    <form action="{{ route('formula.createBazin') }}" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="container" id="caixa">
        <h1 class="mt-4 mb-4">Fórmula de Graham</h1>
        <div class="opcoes">
          <div class="col-md-3">
            <label for="nome" class="form-label">Nome do ativo:</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
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
</section>
<section class="secao_formula_2">
  <div class="container" id="caixa_2">
    <h1 class="mt-2 mb-4">Bazin</h1>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>   
            <th>Nome:</th>
            <th>DPA:</th>   
            <th>Dividend yield:</th> 
            <th>Preço teto:</th> 
            <th>Opções:</th>             
          </tr>
        </thead>
        <tbody>
          @foreach($dadosBazin as $bazin)     
            <tr>
              <td>{{ $bazin['nome'] }}</td>     
              <td>{{ $bazin['dpa'] }}</td>
              <td>{{ $bazin['dividend_yield'] }} %</td>
              <td>R$ {{ $bazin['preco_teto'] }}</td>
              <td class="buttons"> 
                <form action="{{ route('formula.editBazin', ['id' => $bazin['id']]) }}" method="GET" style="display: inline;">
                  {{ csrf_field() }}
                  <button type="submit" class="btn btn-warning">Editar</button>
                </form>
                <form action="{{ route('formula.destroyBazin', ['id' => $bazin['id']]) }}" method="POST" style="display: inline;">
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
<section class="secao_formula_2">
  <div class="container" id="caixa_3">
    <h1 class="mt-2 mb-4">Graham</h1>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Nome:</th>
            <th>DPA:</th>   
            <th>Dividend yield:</th> 
            <th>Preço justo:</th> 
            <th>Opções:</th>                  
          </tr>
        </thead>
        <tbody>
          @foreach($dadosGraham as $graham) 
            <tr>
              <td> {{ $graham['nome'] }}</td>    
              <td> {{ $graham['lpa'] }}</td>
              <td> {{ $graham['vpa'] }}</td>
              <td>R$ {{ $graham['preco_justo'] }}</td>
              <td class="buttons">    
                <form action="{{ route('formula.editBazin', ['id' => $graham['id']]) }}" method="GET" style="display: inline;">
                  {{ csrf_field() }}
                  <button type="submit" class="btn btn-warning">Editar</button>
                </form>
                <form action="{{ route('formula.destroyBazin', ['id' => $graham['id']]) }}" method="POST" style="display: inline;">
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

<script src="js/formulas_opcoes.js"></script>

@endsection
