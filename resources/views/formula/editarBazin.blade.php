@extends('layouts.main')
@section('title', 'Editar Bazin')
@section('content')

<section class="secao_edit_formula">
    <div class="container">
        <h1 class="mt-4 mb-4 text-center">Fórmulas</h1>
        {{-- Formulário para editar de Bazin --}}
        <form action="{{ route('formula.updateBazin', $formula->id) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method('PUT')
            <div class="container" id="caixa">
                <h1 class="mt-4 mb-4">Fórmula de Bazin</h1>
                <div class="opcoes">
                    <div class="col-md-4">
                        <label for="ticker" class="form-label">Ticker:</label>
                        <input type="text" class="form-control" id="ticker" name="ticker" value="{{ $formula->ticker }}" oninput="this.value = this.value.toUpperCase()" required>
                    </div>
                    <div class="col-md-4">
                        <label for="lpa" class="form-label">LPA:</label>
                        <input type="text" class="form-control" id="lpa" name="lpa" value="{{ $formula->lpa }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="payout" class="form-label">Payout:</label>
                        <input type="text" class="form-control" id="payout" name="payout" value="{{ $formula->payout }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="yield_projetado" class="form-label">Yield projetado:</label>
                        <input type="text" class="form-control" id="yield_projetado" name="yield_projetado" value="{{ $formula->yield_projetado }}" required>
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
