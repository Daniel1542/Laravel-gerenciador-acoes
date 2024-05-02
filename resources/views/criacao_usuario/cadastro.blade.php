@extends('layouts.main')
@section('title','Cadastro')
@section('content')

<section class=secao_login>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 text-center">
          <h1 class="mt-4">Cadastro</h1>
      </div>
    </div>
    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
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
        <div class="form-group mt-4">
          <input type="submit" id="botao" class="btn btn-danger btn-sm" value="Cadastrar">
        </div>
      </div>
    </form>
</section> 


@endsection
