@extends('layouts.main')
@section('title', 'Editar Graham')
@section('content')

<section class="secao_edit_formula">
    <div class="container">
        <h1 class="mt-4 mb-4 text-center">Fórmulas</h1>
        {{-- Formulário para editar de Graham --}}
        <form action="{{ route('formula.updateGraham', $formula->id) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method('PUT')
            <div class="container" id="caixa">
                <h1 class="mt-4 mb-4">Fórmula de Graham</h1>
                <div class="opcoes">
                    <div class="col-md-3">
                        <label for="ticker" class="form-label">Ticker:</label>
                        <input type="text" class="form-control" id="ticker" name="ticker" value="{{ $formula->ticker }}" oninput="this.value = this.value.toUpperCase()" required>
                    </div>
                    <div class="col-md-3">
                        <label for="lpa" class="form-label">LPA:</label>
                        <input type="text" class="form-control" id="lpa" name="lpa" value="{{ $formula->lpa }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="vpa" class="form-label">VPA</label>
                        <input type="text" class="form-control" id="vpa" name="vpa" value="{{ $formula->vpa }}" required>
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
