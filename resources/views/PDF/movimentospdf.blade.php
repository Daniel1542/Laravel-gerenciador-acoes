<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">  
  <title>Movimentações</title>
  <style>

    .secao_ativos{
      align-items: center;
      text-align: center;
      padding: 0;
    }
    
    .secao_ativos #caixa {
      margin-top: 20px;
      border-radius: 5px;  
    }

    .secao_ativos .table{
      border-collapse: collapse;
      width: 100%;
    }

    .secao_ativos .table thead th {
      background-color: rgb(73, 140, 199);
      text-align: center;
      border: 1px solid #dee2e6;
      padding: 8px;
      gap: 10px;
    }

    .secao_ativos .table td {
      background-color: rgb(166, 203, 236);
      border: 1px solid #dee2e6;
      text-align: center;
      padding: 8px;
    }
    .secao_ativos .fundos{
      margin-top: 50px
    }

  </style>
</head>
<body>
  <section class="secao_ativos">
    <div id="caixa">
      <h1>Ativos</h1>
      <div>
        <div>
          <h2>Ações</h2>
        </div>
        <table class="table" >
          <thead>
            <tr>
              <th>Nome:</th>   
              <th>Movimento:</th>   
              <th>Quantidade:</th>
              <th>Valor:</th>       
              <th>Corretagem:</th>
              <th>Total:</th>
              <th>Data:</th>             
            </tr>
          </thead>
          @foreach($dadosAcoes as $acao)         
            <tr>
              <td> {{ $acao['nome'] }}</td>
              <td> {{ $acao['movimento'] }}</td> 
              <td> {{ $acao['quantidade'] }}</td>         
              <td> R$ {{ $acao['valor'] }}</td>
              <td> R$ {{ $acao['corretagem'] }}</td> 
              <td> R$ {{ $acao['valor_total'] }}</td> 
              <td> {{ $acao['data']}}</td>                              
            </tr> 
          @endforeach    
        </table>
        <div class="fundos">
          <h2>Fundos</h2>
        </div>
        <table class="table" >
          <thead>
            <tr>
              <th>Nome:</th>   
              <th>Movimento:</th>   
              <th>Quantidade:</th>
              <th>Valor:</th>       
              <th>Corretagem:</th>
              <th>Total:</th>
              <th>Data:</th>             
            </tr>
          </thead>
          @foreach($dadosFiis as $acao)         
            <tr>
              <td> {{ $acao['nome'] }}</td>
              <td> {{ $acao['movimento'] }}</td> 
              <td> {{ $acao['quantidade']}}</td>         
              <td> R$ {{ $acao['valor'] }}</td>
              <td> R$ {{ $acao['corretagem'] }}</td> 
              <td> R$ {{ $acao['valor_total'] }}</td> 
              <td> {{ $acao['data']}}</td>                           
            </tr> 
          @endforeach    
        </table>
      </div>
    </div>
  </section>
</body>
</html>

 

