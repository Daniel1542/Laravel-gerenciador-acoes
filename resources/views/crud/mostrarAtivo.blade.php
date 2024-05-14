@extends('layouts.main')
@section('title','Ativos')
@section('content')

<section class='secao_mostrar_ativo'>
  <div class="container" id="caixa">
    <div class="row justify-content-center">
      <div class="col-md-6 text-center">
        <h1 class="mt-2 mb-2">Ativos</h1>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>   
            <th>Nome:</th>
            <th>Movimento</th>   
            <th>Quantidade: </th>
            <th>Valor: </th>       
            <th>Corretagem: </th>
            <th>Valor total: </th>    
            <th>Data: </th>  
            <th>Opções:</th>               
          </tr>
        </thead>
        <tbody>
          {{-- Loop dados de ativos --}}
          @foreach($dadosAtivos as $ativos)
            <tr>
              <td> {{ $ativos['nome'] }}</td>
              <td> {{ $ativos['movimento'] }}</td> 
              <td> {{ $ativos['quantidade']}}</td>         
              <td>R$ {{ number_format($ativos['valor'], 2) }}</td>
              <td>R$ {{ number_format($ativos['corretagem'], 2) }}</td>
              <td>R$ {{ number_format($ativos['valorFinal'], 2) }}</td>
              <td> {{ $ativos['data']}}</td>        
              <td class="buttons">
                <form action="{{ route('ativos.edit', ['id' => $ativos['id']]) }}" method="GET">
                  {{ csrf_field() }}
                  <button type="submit" class="btn btn-warning">Editar</button>
                </form>
                <form action="{{ route('ativos.destroy', ['id' => $ativos['id']]) }}" method="POST">
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
    <div class="buttons">
      <form action="{{ route('movimento.index') }}" method="GET">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-primary">Voltar</button>
      </form>
    </div>
  </div>
</section>
@endsection