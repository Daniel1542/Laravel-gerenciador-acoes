@extends('layouts.maindashboard')
@section('title','Cadastrar')
@section('content')

<section class="secao_acoes">
  <div class="container" id="caixa">
    <h1 class="mb-2">Cadastrar</h1>
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
</section>

@endsection