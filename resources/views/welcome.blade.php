@extends('layouts.main')
@section('title','Login')
@section('content')

<section class=secao_login>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 text-center">
          <h1 class="mt-4">Login</h1>
      </div>
    </div>
    <form action="/auth" method="POST">
      <div id="caixa" class="form-group">
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
      </div>
    </form>
  </div>
</section> 

@endsection
