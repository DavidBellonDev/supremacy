$(document).ready(function() {

    //Click para salvar o Produto
    $('#salvarProduto').on('click', function (e) {
        e.preventDefault();
        removerMascaras();

        $.ajax({
            type: 'post',
            url: $('#formProduto').attr('action'), // Rota definida no Routes.php
            data: $('#formProduto').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso',
                        text: response.mensagem
                    }).then(() => {
                        window.location.href = "/produtos";
                    });
                }else if(response.status === 'restore'){
                    Swal.fire({
                        title: 'Código já existe',
                        text: response.mensagem,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Restaurar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "/produtos/restaurar/" + response.id,
                                type: "GET",
                                 dataType: 'json',
                                success: function (res) {
                                    Swal.fire('Restaurado!', res.mensagem, 'success').then(() => {
                                        window.location.href = "/produtos";
                                    });
                                }
                            });
                        }
                    });
                }
            },
            error: function(xhr) {

                iniciarMascaras();

                if (!xhr.responseJSON) {
                    Swal.fire('Erro', 'Falha na comunicação com o servidor.', 'error');
                    return;
                }

                const response = xhr.responseJSON;

                //Erro de Validação (ValidationException)
                if (response.status === 'validation_error') {
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();

                    $.each(response.errors, function (campo, mensagem) {
                        const input = $('[name="' + campo + '"]');
                        input.addClass('is-invalid');
                        input.after('<div class="invalid-feedback">' + mensagem + '</div>');
                    });

                    return;
                }

                // Erro de Regra/Sistema
                if (response.errors && response.errors._global) {
                    Swal.fire('Erro', response.errors._global, 'error');
                    return;
                }

                Swal.fire('Erro', response.mensagem || 'Erro inesperado', 'error');
            }
        });
    });
});