@extends('layouts.mainDashboard')
@section('title', 'Editar')
@section('content')

<section class="secao_formula">
    <div class="container">
        <h1 class="mt-4 mb-4 text-center">Fórmulas</h1>
        {{-- Formulário para editar de Bazin --}}
        <form action="{{ route('formula.updateBazin', $formula->id) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method('PUT')
            <div class="container" id="caixa">
                <h1 class="mt-4 mb-4">Fórmula de Bazin</h1>
                <div class="opcoes">
                    <div class="col-md-3">
                        <label for="ticker" class="form-label">Ticker:</label>
                        <input type="text" class="form-control" id="ticker" name="ticker" value="{{ $formula->ticker }}" oninput="this.value = this.value.toUpperCase()" required>
                    </div>
                    <div class="col-md-3">
                        <label for="dpa" class="form-label">DPA:</label>
                        <input type="text" class="form-control" id="dpa" name="dpa" value="{{ $formula->dpa }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="dividend_yield" class="form-label">Yield estimado:</label>
                        <input type="text" class="form-control" id="dividend_yield" name="dividend_yield" value="{{ $formula->dividend_yield }}" required>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-custom">Editar</button>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection
