$(document).ready(function() {

    //Click para salvar o Produto
    $('#salvarProduto').on('click', function (e) {
        e.preventDefault();
        //Retirar a mascara monetária dos campos Preco e Custo
        $('.money, .estoque').each(function () {
            let valor = $(this).val();
            valor = valor.replace(/\./g, '').replace(',', '.');
            $(this).val(valor);
        });

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