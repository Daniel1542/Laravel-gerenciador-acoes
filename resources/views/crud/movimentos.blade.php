@extends('layouts.maindashboard')
@section('title', 'Movimentações')
@section('content')

  <section class="secao_movimento">
    <div class="container text-center">
      <h1 class="mt-4 mb-4">Buscar ativo</h1>
      <div class="container mb-4">     
        <form class="formulario1" action="{{ route('ativos.show') }}" method="GET">
          {{ csrf_field() }}
          <label for="Nome">Nome:</label>
          <div class="autocomplete">
            <input type="text" id="Nome" name="Nome" autocomplete="off">
            <ul id="suggestions"></ul>
          </div>
          <button class="btn btn-primary" type="submit">Buscar</button>
        </form>
      </div> 
      <div class="container mt-4">
        <form class="formulario2" action="{{ route('movimento.exportMovimentoAtivos') }}" method="GET">
          {{ csrf_field() }}
          <div class="row mb-3">
            <div class="col-md-4 mb-3">
              <label for="data_inicio" class="form-label">Data Início:</label>
              <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="data_fim" class="form-label">Data Fim:</label>
              <input type="date" class="form-control" id="data_fim" name="data_fim" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="tipo" class="form-label">Tipo:</label>
              <select class="form-select" id="tipo" name="tipo" required>
                <option value="acao">Ação</option>
                <option value="fundo imobiliario">Fundo Imobiliário</option>
              </select>
            </div>
          </div>
          <div class="mb-1">
            <button type="submit" class="btn btn-custom mb-1 mx-2">Baixar Excel</button>
            <a class="btn btn-custom mb-1 mx-2" href="{{ route('movimento.exportMovimentoAtivosPdf', ['data_inicio' => request('data_inicio'), 'data_fim' => request('data_fim'), 'tipo' => request('tipo')]) }}">Baixar PDF de todos ativos</a>
          </div>
        </form>
      </div>
    </div>
    <div class="container" id="caixa">
      <div class="row justify-content-center">
        <div class="col-md-6 text-center">
          <h1 class="mt-2" style="margin-bottom:20px;">Ações</h1>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table" >
          <thead>
          <tr>   
            <th class="opcoes-a">Ação:</th>
            <th class="opcoes-a">Movimento</th>   
            <th class="opcoes-a">Quantidade: </th>
            <th class="opcoes-a">Valor: </th>       
            <th class="opcoes-a">Corretagem: </th>
            <th class="opcoes-a">Data: </th>   
            <th class="opcoes-a">Opções</th>         
          </tr>
          </thead>
          @foreach($dadosAcoes as $acao)         
            <tr>
              <td> {{ $acao['nome'] }}</td>
              <td> {{ $acao['movimento'] }}</td> 
              <td> {{ $acao['quantidade']}}</td>         
              <td> {{ $acao['valor'] }}</td>
              <td> {{ $acao['corretagem'] }}</td> 
              <td> {{ $acao['data']}}</td>     
              <td class="buttons">
                <form action="{{ route('ativos.edit', ['id' => $acao['id']]) }}" method="GET" style="display: inline;">
                  {{ csrf_field() }}
                  <button type="submit" class="btn btn-warning">Editar</button>
                </form>
                <form action="{{ route('ativos.destroy', ['id' => $acao['id']]) }}" method="POST" style="display: inline;">
                  {{ csrf_field() }}
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                </form>              
              </td>                 
            </tr> 
          @endforeach    
        </table>
      </div>
    </div>
    <div class="container" id="caixa2">
      <div class="row justify-content-center">
        <div class="col-md-6 text-center">
          <h1 class="mt-2" style="margin-bottom:20px;">Fiis</h1>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table" >
          <thead>
          <tr>
            <th class="opcoes-a">Ação:</th>
            <th class="opcoes-a">Movimento</th>   
            <th class="opcoes-a">Quantidade: </th>
            <th class="opcoes-a">Valor: </th>       
            <th class="opcoes-a">Corretagem: </th>
            <th class="opcoes-a">Data: </th>   
            <th class="opcoes-a">Opções</th>     
          </tr>
          </thead>
          @foreach($dadosFiis as $fii)      
            <tr>
              <td> {{ $fii['nome'] }}</td>
              <td> {{ $fii['movimento'] }}</td> 
              <td> {{ $fii['quantidade']}}</td>         
              <td> {{ $fii['valor'] }}</td>
              <td> {{ $fii['corretagem'] }}</td> 
              <td> {{ $fii['data']}}</td>           
              <td class="buttons">       
                <form action="{{ route('ativos.edit', ['id' => $fii['id']]) }}" method="GET" style="display: inline;">
                  {{ csrf_field() }}
                  <button type="submit" class="btn btn-warning">Editar</button>
                </form>
                <form action="{{ route('ativos.destroy', ['id' => $fii['id']]) }}" method="POST" style="display: inline;">
                  {{ csrf_field() }}
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                </form>              
              </td>                 
            </tr> 
          @endforeach    
        </table>
      </div>
    </div>
  </section>
  <script>
    $(document).ready(function () {
        var addedSuggestions = new Set();  // Conjunto para armazenar sugestões únicas

        $('#Nome').on('input', function () {
            var inputText = $(this).val().toLowerCase();

            $.ajax({
                url: '/buscar-ativos',
                method: 'GET',
                data: { termo: inputText },
                success: function (response) {
                    var suggestionsList = $('#suggestions');
                    suggestionsList.empty();

                    response.forEach(function (suggestion) {
                        // Adiciona à lista apenas se não estiver presente no conjunto
                        if (!addedSuggestions.has(suggestion)) {
                            suggestionsList.append('<li class="suggestion">' + suggestion + '</li>');
                            addedSuggestions.add(suggestion);  // Adiciona à lista de sugestões únicas
                        }
                    });

                    // Adicionar evento de clique para preencher o input com a sugestão selecionada
                    $('.suggestion').on('click', function () {
                        $('#Nome').val($(this).text());
                        suggestionsList.empty();
                        addedSuggestions.clear();  // Limpa o conjunto ao selecionar uma sugestão
                    });
                },
                error: function () {
                    console.error('Erro ao buscar sugestões via Ajax.');
                }
            });
        });

        // Ocultar a lista quando clicar fora do input
        $(document).on('click', function (e) {
            if (!$(e.target).closest('.autocomplete').length) {
                $('#suggestions').empty();
                addedSuggestions.clear();  // Limpa o conjunto ao fechar a lista
            }
        });
    });
</script>

@endsection
