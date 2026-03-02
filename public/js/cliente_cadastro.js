$(document).ready(function() {

    //Função para carregar máscaras
    carregarMascaras();

    // Click para salvar o cliente
    $('#salvarCliente').on('click', function (e) {
        e.preventDefault();
        //Retirar a máscara dos campos...
         $('#cpf, #cnpj, #cep, #rg, #telefone, #celular').unmask();

        $.ajax({
            type: 'post',
            url: $('#formCliente').attr('action'), // Rota definida no Routes.php
            data: $('#formCliente').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso',
                        text: response.mensagem
                    }).then(() => {
                        window.location.href = "/clientes";
                    });
                }else if(response.status === 'restore'){
                    Swal.fire({
                        title: 'Cliente já existe',
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
                                url: "/clientes/restaurar/" + response.id,
                                type: "GET",
                                 dataType: 'json',
                                success: function (res) {
                                    if(res.status === 'success'){
                                        Swal.fire('Restaurado!', res.mensagem, 'success').then(() => {
                                            window.location.href = "/clientes";
                                        });
                                    }else if(res.status === 'error'){
                                        Swal.fire('Erro!', res.mensagem, 'error');
                                    }
                                }
                            });
                        }
                    });
                }
            },
            error: function(xhr) { // Erros 
                   
                carregarMascaras(); //Função para carregar máscaras
                
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

    function carregarMascaras(){
        //Máscaras para campo CPF, CNPJ, CEP, Telefone e Celular
        // CPF
        $('#cpf').mask('000.000.000-00');

        // CNPJ
        $('#cnpj').mask('00.000.000/0000-00');

        // CEP
        $('#cep').mask('00000-000');

        //RG
        $('#rg').mask('00.000.000-0');

        // Telefone fixo
        $('#telefone').mask('(00) 0000-0000');

        // Celular (com 9 dígitos)
        $('#celular').mask('(00) 00000-0000');
    }
});
