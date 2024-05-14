<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/app.css">
  <link rel="stylesheet" href="/css/secao_ativos.css">
  <link rel="stylesheet" href="/css/modal_add_ativos.css">
  <link rel="stylesheet" href="/css/secao_dash.css">
  <link rel="stylesheet" href="/css/secao_ir.css">
  <link rel="stylesheet" href="/css/secao_movimento.css">
  <link rel="stylesheet" href="/css/secao_formula.css">

  <!-- Font awesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css" integrity="sha384-BY+fdrpOd3gfeRvTSMT+VUZmA728cfF9Z2G42xpaRkUGu2i3DyzpTURDo5A6CaLK" crossorigin="anonymous">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
  <title>@yield('title')</title>
  <!-- bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <!-- Bootstrap JavaScript (jQuery e Popper.js) -->
  <link rel="stylesheet" href="/js/app.js">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body class="corpo">
  <header>
    {{-- logo do site no menu --}}
    <div class="dropdown">
      <a href="{{ route('principal.dashboard') }}">
        <img class="logo" src="logo/bear_and_bull.svg" alt="logo">
      </a>
    </div>
    {{-- menu responsivo --}}
    <div class="col-lg-3">
      <div class="dropdown d-lg-none">
        <button class="btn btn-secondary dropdown-toggle me-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Menu
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <button id="mobileBtn" class="dropdown-item">Compra e venda</button>
          <li><a class="dropdown-item" href="{{ route('lista.index')}}">Mostrar ativos</a></li>
          <li><a class="dropdown-item" href="{{ route('imposto.index')}}">Imposto de renda</a></li>
          <li><a class="dropdown-item" href="{{ route('movimento.index')}}">Movimentações</a></li>
          <li><a class="dropdown-item" href="{{ route('formula.index')}}">Fórmulas</a></li>
          <li><a class="dropdown-item" href="{{ route('logout')}}">Sair</a></li>
        </ul>    
      </div>
    </div>
    {{-- Menu no pc --}}
    <div class="dropdown d-none d-lg-block" >
      <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        Ativos
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <button id="desktopBtn" class="dropdown-item">Compra e venda</button>
        <li><a class="dropdown-item" href="{{ route('lista.index')}}">Mostrar</a></li>
        <li><a class="dropdown-item" href="{{ route('formula.index')}}">Fórmulas</a></li>
      </ul>    
    </div>
    <div class="dropdown d-none d-lg-block">
      <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        Imposto de renda
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li><a class="dropdown-item" href="{{ route('imposto.index')}}">Mostrar</a></li>
      </ul>    
    </div>
    <div class="dropdown d-none d-lg-block">
      <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        Movimentações
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li><a class="dropdown-item" href="{{ route('movimento.index')}}">Movimentos dos ativos</a></li>
      </ul>    
    </div>
    <div class="d-none d-lg-block">
      <a class="btn btn-secondary" href="{{ route('logout') }}">Sair</a>
    </div>  
  </header>
  <main>
    @if (session('msg'))
    <div class="alert alert-danger">
      {{ session('msg') }}
    </div>
    @endif
    @if ($errors->any())
      <div class="alert alert-danger mt-4"> 
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif 
    @yield('content')
    {{-- modal para cadastrar ativo --}}
    <div id="modalAddAtivo" class="modal">
      <div class="modal-content-add">
        <div class="container" id="caixa">
          <span class="close">&times;</span>
          <h1 class="mb-2 text-center">Cadastrar</h1>
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
      </div>
    </div>
  </main>
  <footer>
    <p>&copy; 2024 Daniel</p>
    <nav>
      <a href="#">Página Inicial</a>
      <a href="#">Sobre Nós</a>
      <a href="#">Contato</a>
    </nav>
  </footer>
  <script src="js/modal_add_ativos.js"></script>

</body>
</html>