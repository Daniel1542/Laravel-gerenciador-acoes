<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ativos</title>
    <style>
      *{    
        padding: 0;
        font-family: 'Roboto';
      }
      .secao_ir{
        align-items: center;
        text-align: center;
        padding: 0;
      }
    
      .secao_ir #caixa {
        padding: 20px ;
        border-radius: 5px;  
      }
      
      .secao_ir .table{
        border-collapse: collapse;
        width: 100%;
      }

      .secao_ir .table td {
        border: 1px solid #dee2e6;
        padding: 10px;
      }
      .secao_ir .fundos{
        margin-top: 50px
      }
      
    </style>
  </head>
  <body>
      <section class="secao_ir">
        <div id="caixa">
          <h1>Imposto de renda</h1>
          <div>
            <div>
              <h2>Ações</h2>
            </div>
            <table class="table">
              @foreach ($dadosAtivos as $ativo)
                @if (isset($ativo['compra']['quantidadeTotal']) && ($ativo['compra']['total']) > 0)
                  <tr>
                    <td> Compra de {{ $ativo['compra']['quantidadeTotal'] }} ações de {{ $ativo['nome'] }}, custo total {{number_format ($ativo['compra']['total'], 2) }} reais.</td>    
                  </tr>
                @endif
              @endforeach
              @foreach ($dadosAtivos as $ativo)
                @if (isset($ativo['venda']['quantidadeTotal']) && ($ativo['venda']['total'])> 0)
                  <tr>
                    <td> Venda de {{ $ativo['venda']['quantidadeTotal'] }} ações de {{ $ativo['nome'] }}, custo total {{ number_format($ativo['venda']['total'], 2) }} reais.</td>
                  </tr>
                @endif
              @endforeach
            </table>
            <div class="fundos">
              <h2>Fundos</h2>
            </div>
            <table class="table">
              @foreach ($dadosfiis as $ativo)
                @if (isset($ativo['compra']['quantidadeTotal']) && ($ativo['compra']['total']) > 0)
                  <tr>
                    <td> Compra de {{ $ativo['compra']['quantidadeTotal'] }} ações de {{ $ativo['nome'] }}, custo total {{number_format ($ativo['compra']['total'], 2) }} reais.</td>    
                  </tr>
                @endif
              @endforeach
              @foreach ($dadosfiis as $ativo)
                @if (isset($ativo['venda']['quantidadeTotal']) && ($ativo['venda']['total']) > 0)
                  <tr>
                    <td> Venda de {{ $ativo['venda']['quantidadeTotal'] }} ações de {{ $ativo['nome'] }}, custo total {{ number_format($ativo['venda']['total'], 2) }} reais.</td>
                  </tr>
                @endif
              @endforeach
            </table>
          </div>   
        </div>      
      </section>  
  </body>
</html>

