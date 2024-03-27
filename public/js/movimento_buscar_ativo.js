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