$(document).ready(function() {

    //Buscar dados do pedido
    let id = $('#id').val();
    let finalizado = $('#finalizado').val();

    if(id > 0){ // Se for uma edição de pedido
        $("#nome_cliente").prop('readonly', true); //Bloquear campo de cliente
        $("#editar_cliente").prop('disabled', false); //Liberar botão de editar cliente
    }else{
        //Não mostrar a aba de itens
        $('#itens').hide();
    }

    //Pedido finalizado bloqueia todos campos e apaga botão salvar pedido/item e add item
    if(finalizado == 1){
        $("#editar_cliente").prop('disabled', true); //Bloquear botão de editar cliente
        $("#status").prop('readonly', true); 
        $("#observacao").prop('readonly', true); 
        $("#desconto").prop('readonly', true); 
        $("#salvarPedido").hide(); 
    }

    //Clique para editar o cliente do pedido
    $(document).on('click', '#editar_cliente', function(){

        $("#nome_cliente").prop('readonly', false); //Liberar campo de cliente
        $("#editar_cliente").prop('disabled', true); //Bloquear botão de editar cliente

        //Limpar os dados do cliente
        $("#id_cliente").val(0);
        $("#nome_cliente").val('');
        $("#cpf_cliente").val('');
        $("#cnpj_cliente").val('');
        $("#endereco_cliente").val('');
        $("#numero_cliente").val('');
        $("#complemento_cliente").val('');
        $("#cidade_cliente").val('');
        $("#estado_cliente").val('');
    });

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

        if(finalizado == 1){
            //Bloquear Botão para editar item
            $("#editar_produto").prop('disabled', true);
            $("#valor_item").prop('readonly', true);
            $("#quantidade_item").prop('readonly', true);
            $("#desconto_item").prop('readonly', true);
            $("#total_item").prop('readonly', true);
            $("#observacao_item").prop('readonly', true);
            $("#salvarItem").hide();
        }
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
        removerMascaras();
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
                        if(response.acao == 'criar'){
                            //Pedido novo, abrir modal de itens
                            $('#modalNovoItem').modal('show'); //Abrir o modal
                            $('#id_pedido').val(response.idNovoPedido);
                            $('#id').val(response.idNovoPedido);
                            $('#pedido').val(response.numeroPedido);
                            $('#itens').show();
                        }else{
                            window.location.href = "/pedidos";
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

    //Click para salvar o Item
    $('#salvarItem').on('click', function (e) {
        e.preventDefault();
        removerMascaras();
        $.ajax({
            type: 'post',
            url: $('#formItem').attr('action'), // Rota definida no Routes.php
            data: $('#formItem').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    //Remove efeitos de erro caso tenha ocorrido antes
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();

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
                        if(campo == 'descricao_produto'){
                            const btn = $('#editar_produto');
                            btn.after('<div class="invalid-feedback">' + mensagem + '</div>');
                        }else{
                            input.after('<div class="invalid-feedback">' + mensagem + '</div>');
                        }
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

    //Click para cancelar o Item
    $('#cancelarItem').on('click', function (e) {
        e.preventDefault();
        //Remove efeitos de erro caso tenha ocorrido antes
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        $('#modalNovoItem').modal('hide'); //Fechar modal
    });

    //Clique no botão Excluir o Item
    $('#listaItens').on('click', '.excluir', function () {
        let idPedido = $('#id_pedido').val();
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
                    url: "/itens/excluir/" + id + "/" + idPedido,
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
                        }
                    },
                    error: function (xhr) {
                        if (!xhr.responseJSON) {
                            Swal.fire('Erro', 'Falha na comunicação com o servidor.', 'error');
                            return;
                        }
                        const response = xhr.responseJSON;
                         // Erro de Regra/Sistema
                        if (response.errors && response.errors._global) {
                            Swal.fire('Erro', response.errors._global, 'error');
                            return;
                        }

                        Swal.fire('Erro!', 'Não foi possível excluir o item.', 'error');
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
                $("#nome_cliente").prop('readonly', true); //Bloquear campo de cliente
                $("#editar_cliente").prop('disabled', false); //Liberar botão de editar cliente
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