@extends('layouts.mainDashboard')
@section('title', 'Fórmulas')
@section('content')

<section class="secao_formula">
  <div class="container" id="container_formulas">
    <h1 class="mt-4 mb-4 text-center">Fórmulas</h1>
    {{--botões para cadastro de fórmulas --}}
    <div class="opcoes">
      <div class="opcoes_formulas">
        <label for="Bazin">Formula de Bazin</label>
        <button id="bazinBtn" class="btn btn-custom">Adicionar</button>
      </div>
      <div class="opcoes_formulas">
        <label for="Graham">Formula de Graham</label>
        <button id="grahamBtn" class="btn btn-custom">Adicionar</button>
      </div>
    </div> 
    {{-- modal para cadastrar bazin --}}
    <div id="modalAddBazin" class="modal">
      <div class="modal-content-add-formula">
        <div class="container" id="caixa">
          <span class="close">&times;</span>
          <h1 class="mt-4 mb-4 text-center">Fórmula de Bazin</h1>
          <form action="{{ route('formula.createBazin') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="opcoes">
              <div class="col-md-3">
                <label for="ticker" class="form-label">Ticker:</label>
                <input type="text" class="form-control" id="ticker" name="ticker" oninput="this.value = this.value.toUpperCase()" required>
              </div>
              <div class="col-md-3">
                <label for="lpa" class="form-label">LPA:</label>
                <input type="text" class="form-control" id="lpa" name="lpa" required>
              </div>
              <div class="col-md-3">
                <label for="payout" class="form-label">Payout:</label>
                <input type="text" class="form-control" id="payout" name="payout" required>
              </div>
              <div class="col-md-3">
                <label for="yield_projetado" class="form-label">Yield projetado:</label>
                <input type="text" class="form-control" id="yield_projetado" name="yield_projetado" required>
              </div>
            </div>
            <div class="button">
              <button type="submit" class="btn btn-custom">Salvar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    {{-- Modal para cadastro de Graham --}}
    <div id="modalAddGraham" class="modal">
      <div class="modal-content-add-formula">   
        <div class="container" id="caixa_1">
          <span class="close">&times;</span>
          <h1 class="mt-4 mb-4 text-center">Fórmula de Graham</h1>
          <form action="{{ route('formula.createGraham') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="opcoes">
              <div class="col-md-3">
                <label for="ticker" class="form-label">Ticker:</label>
                <input type="text" class="form-control" id="ticker" name="ticker" oninput="this.value = this.value.toUpperCase()" required>
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
            <div class="button">
              <button type="submit" class="btn btn-custom">Salvar</button>
            </div>        
          </form> 
        </div> 
      </div>
    </div>
  </div>
</section>
{{-- Seção para tabela de Bazin --}}
<section class="secao_formula_2">
  <div class="container" id="caixa_2">
    <h1 class="mt-2 mb-4">Bazin</h1>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>   
            <th>Ticker:</th>
            <th>LPA projetado:</th>   
            <th>Payout projetado:</th>   
            <th>DPA projetado:</th>   
            <th>Yield projetado:</th> 
            <th>Preço teto:</th> 
            <th>Opções:</th>             
          </tr>
        </thead>
        {{-- Vue para tabela de Bazin --}}
        <tbody id="app2" data-dados-bazin="{{ json_encode($dadosBazin) }}">
          <template v-for="bazin in dadosBazin">
            <Tablebazin :row="bazin" :key="bazin.id"></Tablebazin>
          </template>
        </tbody>        
      </table>
    </div>
  </div>
</section>
{{-- Seção para tabela de Graham --}}
<section class="secao_formula_2">
  <div class="container" id="caixa_3">
    <h1 class="mt-2 mb-4">Graham</h1>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Ticker:</th>
            <th>LPA:</th>   
            <th>VPA:</th> 
            <th>Preço justo:</th> 
            <th>Opções:</th>                  
          </tr>
        </thead>
        <tbody>
          {{-- Vue para tabela de Graham --}}
          <tbody id="app3" data-dados-graham="{{ json_encode($dadosGraham) }}">
            <template v-for="graham in dadosGraham">
              <Tablegraham :row="graham" :key="graham.id"></Tablegraham>
            </template>
          </tbody>    
        </tbody>    
      </table>
    </div>
  </div>
</section>

<script src="js/modal_add_bazin.js"></script>
<script src="js/modal_add_graham.js"></script>

@endsection