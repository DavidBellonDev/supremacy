$(document).ready(function() {

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

    $('#salvarCliente').on('click', function (e) {
        e.preventDefault();
         $('#cpf, #cnpj, #cep, #rg, #telefone, #celular')
        .unmask();

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
                                    Swal.fire('Restaurado!', res.mensagem, 'success').then(() => {
                                        window.location.href = "/clientes";
                                    });
                                }
                            });
                        }
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
    });
});
