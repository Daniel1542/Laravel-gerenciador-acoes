@extends('layouts.main')
@section('title','Login')
@section('content')

<section class=secao_login>
  <div class="container">
    <div class="titulo">
      <img class="logotipo" src="logo/bear_and_bull.svg" alt="Logotipo">
      <h1>Gerenciador de ações</h1>
    </div>
    <h1 class="text-center">Login</h1> 
    <div id="caixa" class="form-group">
      <form action="/auth" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="password">Senha:</label>
          <input type="password" id="password" name="password" required>
        </div>       
        <div class="form-group text-center">
          <a href="/cadastro">Cadastre-se</a>
        </div>        
        <div class="form-group mt-2">
          <input type="submit" id="botao" class="btn btn-danger btn-sm" value="Logar">
        </div>
      </form>
    </div>
  </div>
</section> 

@endsection