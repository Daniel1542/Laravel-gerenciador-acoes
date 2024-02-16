@extends('layouts.maindashboard')
@section('title','Cadastrar')
@section('content')

<section class='secao_acoes'>
    <div class="container" id="cima">
        <div class="row justify-content-left">
            <div class="col-md-6 text-left">
                <h1 class="mt-4">Pergunte</h1>
            </div>
        </div>
        <div>
            <input type="text" id="perguntaInput" placeholder="Digite sua pergunta">
            <button onclick="enviarPergunta()">Enviar</button>
            <div id="respostas"></div>
        </div>
    </div>
</section>

<script>
    function enviarPergunta() {
        var pergunta = $('#perguntaInput').val();

        // Verifique se a pergunta não está vazia antes de enviar
        if (pergunta.trim() !== "") {
            // Faça uma chamada AJAX para a API do ChatGPT
            $.ajax({
                url: 'URL_DA_SUA_API_CHATGPT',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ pergunta: pergunta }),
                success: function (resposta) {
                    exibirResposta(resposta);
                },
                error: function () {
                    console.error('Erro ao enviar pergunta para o ChatGPT.');
                }
            });
        }
    }

    function exibirResposta(resposta) {
        // Adicione a resposta ao elemento HTML desejado
        $('#respostas').append('<p>' + resposta + '</p>');

        // Limpe o campo de entrada
        $('#perguntaInput').val('');
    }
</script>

@endsection