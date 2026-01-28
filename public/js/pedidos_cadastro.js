$(document).ready(function() {

    //Click para salvar o Produto
    $('#salvarPedido').on('click', function (e) {
        e.preventDefault();
        //Retirar a mascara monetária dos campos Total e Desconto
        $('.money').each(function () {
            let valor = $(this).val();
            valor = valor.replace(/\./g, '').replace(',', '.');
            $(this).val(valor);
        });
        $.ajax({
            type: 'post',
            url: $('#formPedido').attr('action'), // Rota definida no Routes.php
            data: $('#formPedido').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso',
                        text: response.mensagem
                    }).then(() => {
                        window.location.href = "/pedidos";
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

    //Buscando clientes para selecionar no pedido   
    $(function () {
        $("#nome_cliente").autocomplete({
            minLength: 2,
            delay: 300,
            source: function (request, response) {
                $.ajax({
                    url: '/clientes/buscar_pedido',
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            select: function (event, ui) {
                $("#nome_cliente").val(ui.item.value);
                $("#cpf_cliente").val(ui.item.cpf);
                $("#cnpj_cliente").val(ui.item.cnpj);
                $("#id_cliente").val(ui.item.id);
                $("#endereco_cliente").val(ui.item.endereco);
                $("#numero_cliente").val(ui.item.numero);
                $("#complemento_cliente").val(ui.item.complemento);
                $("#cidade_cliente").val(ui.item.cidade);
                $("#estado_cliente").val(ui.item.estado);
                return false;
            }
        });
    });
});