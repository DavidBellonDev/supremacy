$(document).ready(function(){

    //Máscaras para campo CPF, CNPJ, CEP, Telefone e Celular
    // CPF
    $('#cpf').mask('000.000.000-00');

    // CNPJ
    $('#cnpj').mask('00.000.000/0000-00');

    // CEP
    $('#cep').mask('00000-000');

    // Telefone fixo
    $('#telefone').mask('(00) 0000-0000');

    // Celular (com 9 dígitos)
    $('#celular').mask('(00) 00000-0000');

    //Comportamentos ao clicar no botão 'Editar Empresa'
    $('#btnEditarEmpresa').on('click', function () {
        const btn = $(this);
        var mode = btn.data('mode');

        if (mode === 'editar') {
            //Liberar campo de produto
            $('.dados-empresa').prop('readonly', false);
            $('.campo-select').prop('disabled', false); // Selects, radios, checkbox
        
            //Mudar o texto do botão
            $('#btnEditarEmpresa').text('Salvar');
            $('#btnEditarEmpresa').removeClass('btn-danger').addClass('btn-success');
            btn.data('mode', 'salvar');

        } else {
            //Retirar a máscara dos campos...
            $('#cpf, #cnpj, #cep, #telefone, #celular').unmask();

            //Enviando valor do Estado no input hidden
            $('#estado_hidden').val($('#estado').val());

            // Salvar dados
            $.ajax({
                type: 'post',
                url: $('#editarEmpresa').attr('action'), // Rota definida no Routes.php
                data: $('#editarEmpresa').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso',
                            text: response.mensagem
                        });
                    }else {
                        let erros = '';
                        $.each(response.errors, function(campo, erro) {
                            erros += erro + '\n';
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: erros
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Falha na comunicação com o servidor.'
                    });
                }
            });
            // Travar inputs
            $('.dados-empresa').prop('readonly', true);
            $('.campo-select').prop('disabled', true); // Selects, radios, checkbox

            btn.text('Editar empresa').removeClass('btn-success').addClass('btn-danger');
            btn.data('mode', 'editar');
        }
    });


});