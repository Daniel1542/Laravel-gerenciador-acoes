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
        background-color: rgb(166, 203, 236);
        border: 2px solid rgb(245, 237, 237);
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
                @if ($ativo['compra']['quantidadeTotal'] > 0 && ($ativo['compra']['total']) > 0)
                  <tr>
                    <td> Compra de {{ $ativo['compra']['quantidadeTotal'] }} ações de {{ $ativo['nome'] }}, custo total {{number_format ($ativo['compra']['total'], 2) }} reais.</td>    
                  </tr>
                @endif
              @endforeach
              @foreach ($dadosAtivos as $ativo)
                @if ($ativo['venda']['quantidadeTotal'] > 0 && ($ativo['venda']['total'])> 0)
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
                @if ($ativo['compra']['quantidadeTotal'] > 0 && ($ativo['compra']['total']) > 0)
                  <tr>
                    <td> Compra de {{ $ativo['compra']['quantidadeTotal'] }} ações de {{ $ativo['nome'] }}, custo total {{number_format ($ativo['compra']['total'], 2) }} reais.</td>    
                  </tr>
                @endif
              @endforeach
              @foreach ($dadosfiis as $ativo)
                @if ($ativo['venda']['quantidadeTotal'] > 0 && ($ativo['venda']['total']) > 0)
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