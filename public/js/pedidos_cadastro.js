$(document).ready(function() {

    //Abrir modal para novo item
    $(document).on('click', '#novoItem', function () {
        $('#modalNovoItem').modal('show'); //Abrir o modal

        //Inserir os dados do item nos campos devidos
        $("#id_item").val('');
        $("#descricao_produto").val('');
        $("#id_produto").val('');
        $("#valor_item").val('0,00').trigger('input');
        $("#quantidade_item").val('1').trigger('input');
        $("#desconto_item").val('0,00').trigger('input');
        $("#total_item").val('0,00').trigger('input');
        $("#observacao_item").val('');

        //Liberar campo de produto
        $("#descricao_produto").prop('readonly', false);
        //Bloquear Botão para editar item
        $("#editar_produto").prop('disabled', true);
    });

    //Abrir modal para editar item
    $(document).on('click', '#editarItem', function () {
        $('#modalNovoItem').modal('show'); //Abrir modal
        //Buscar dados do item selecionado
        let id = $(this).data('id');
        let descricao_produto = $(this).data('descricao_produto');
        let valor = $(this).data('valor_modal');
        let quantidade = $(this).data('quantidade_modal');
        let desconto = $(this).data('desconto_modal');
        let observacao = $(this).data('observacao');
        let total = $(this).data('total_modal');

        //Inserir os dados do item nos campos devidos
        $("#id_item").val(id);
        $("#descricao_produto").val(descricao_produto);
        $("#id_produto").val(id);
        $("#valor_item").val(valor).trigger('input');
        $("#quantidade_item").val(quantidade).trigger('input');
        $("#desconto_item").val(desconto).trigger('input');
        $("#total_item").val(total).trigger('input');
        $("#observacao_item").val(observacao);

        //Bloquear campo de produto
        $("#descricao_produto").prop('readonly', true);
        //Liberar Botão para editar item
        $("#editar_produto").prop('disabled', false);
    });

    //Editar o produto do item atual
    $(document).on('click', '#editar_produto', function () {
        //Inserir os dados do item nos campos devidos
        $("#descricao_produto").val('');
        $("#id_produto").val('');
        $("#valor_item").val('0,00').trigger('input');
        $("#quantidade_item").val('1').trigger('input');
        $("#desconto_item").val('0,00').trigger('input');
        $("#total_item").val('0,00').trigger('input');
        $("#observacao").val('');

        //Liberar campo de produto
        $("#descricao_produto").prop('readonly', false);
        //Bloquear Botão para editar item
        $("#editar_produto").prop('disabled', true);
    });

    //Click para salvar o Pedido
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

    //Click para salvar o Item
    $('#salvarItem').on('click', function (e) {
        e.preventDefault();
        //Retirar a mascara monetária dos campos Valor, Total e Desconto
        $('.money').each(function () {
            let valor = $(this).val();
            valor = valor.replace(/\./g, '').replace(',', '.');
            $(this).val(valor);
        });
        $.ajax({
            type: 'post',
            url: $('#formItem').attr('action'), // Rota definida no Routes.php
            data: $('#formItem').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#modalNovoItem').modal('hide'); //Fechar modal
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso',
                        text: response.mensagem
                    }).then(() => {
                       // Recarrega os dados sem reload da página
                        $('#listaItens').DataTable().ajax.reload(null, false);
                        $('#total_fixo').val(response.totalItens);
                        var descontoPedido = parseFloat($('#desconto').val() || 0);
                        var total = response.totalItens - descontoPedido;
                        $("#total").val(total.toLocaleString('pt-BR', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                        }));
                        $("#desconto").val(descontoPedido.toLocaleString('pt-BR', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                        }));
                    });
                }else {
                    $('#modalNovoItem').modal('hide'); //Fechar modal
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
                $('#modalNovoItem').modal('hide'); //Fechar modal
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Falha na comunicação com o servidor.'
                });
            }
        });
    });

    //Clique no botão Excluir o Item
    $('#listaItens').on('click', '.excluir', function () {
        let id = $(this).data('id')
        let descricao_produto = $(this).data('descricao_produto')
        // confirmar exclusão
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja realmente excluir o item " + descricao_produto +  "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/itens/excluir/" + id,
                    type: "DELETE",
                    success: function (response) {
                        if (response.status === 'success') {
                            //Alert de sucesso
                            Swal.fire('Excluído!', response.mensagem, 'success');
                            // Recarrega os dados sem reload da página
                            $('#listaItens').DataTable().ajax.reload(null, false); 
                            $('#total_fixo').val(response.totalItens);
                            var descontoPedido = parseFloat($('#desconto').val() || 0);
                            var total = response.totalItens - descontoPedido;
                            $("#total").val(total.toLocaleString('pt-BR', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                            }));
                            $("#desconto").val(descontoPedido.toLocaleString('pt-BR', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                            }));
                        }else {
                            //Alert de erro
                            Swal.fire('Erro!', response.mensagem, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Erro!', 'Não foi possível excluir o Item', 'error');
                    }
                });
            }
        })
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

    //Buscar os produtos para listar no modal
    $('#modalNovoItem').on('shown.bs.modal', function () {
        $("#descricao_produto").autocomplete({
            minLength: 2,
            delay: 300,
            appendTo: "#modalNovoItem", // MUITO IMPORTANTE
            source: function (request, response) {
                $.ajax({
                    url: '/itens/buscar_itens_pedido',
                    dataType: "json",
                    data: { term: request.term },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            select: function (event, ui) {
                $("#descricao_produto").val(ui.item.value);
                $("#id_produto").val(ui.item.id);
                $("#valor_item").val(ui.item.preco).trigger('input');;
                $("#quantidade_item").val('1');
                $("#desconto_item").val('0');
                $("#total_item").val(ui.item.preco).trigger('input');;
                return false;
            }
        });
    });

    //Calculo do total do Pedido
    function calcularTotalPedido() {
        let totalPedido = parseFloat($('#total_fixo').val() || 0);
        let descontoPedido = moneyParaFloat($('#desconto').val());

        let resultado = totalPedido - descontoPedido;

        if (resultado < 0) resultado = 0.00;

        $('#total').val(resultado.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        })); // reaplica a máscara
    }

    //Calculo do total do item
    function calcularTotalItem() {
        let valor = moneyParaFloat($('#valor_item').val());
        let quantidade = moneyParaFloat($('#quantidade_item').val()) || 0;
        let desconto = moneyParaFloat($('#desconto_item').val());

        let total = (valor * quantidade) - desconto;

        if (total < 0) total = 0;

        $('#total_item')
            .val(floatParaMoney(total))
            .trigger('input'); // reaplica a máscara
    }

    $(document).on('change input', '#desconto', function () {
        calcularTotalPedido();
    });

    $(document).on('input', '#valor_item, #desconto_item', function () {
        calcularTotalItem();
    });

    $(document).on('change input', '#quantidade_item', function () {
        calcularTotalItem();
    });

    // Alterar valores monetários para float, para poder fazer calculos
    function moneyParaFloat(valor) {
        if (!valor) return 0;
        return parseFloat(
            valor
                .replace(/\./g, '')
                .replace(',', '.')
        ) || 0;
    }

    // Alterar valores float para Money
    function floatParaMoney(valor) {
        return valor
            .toFixed(2)
            .replace('.', ',');
    }
});