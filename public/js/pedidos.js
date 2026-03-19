document.addEventListener('DOMContentLoaded', function () {

    //Botão que abre o cadastro de pedidos
    const novoPedido = document.getElementById('novoPedido');
    if (novoPedido) {
        novoPedido.addEventListener('click', function () {
            window.location.href = '/pedidos/pedidos_cadastro/0';
        });
    }

    //Clique no botão Editar do pedido
    $('#listaPedidos').on('click', '.editar', function () {
        let id = $(this).data('id');
        window.location.href = "/pedidos/pedidos_cadastro/" + id;
    });

    //Clique no botão Excluir o Pedido
    $('#listaPedidos').on('click', '.excluir', function () {
        let id = $(this).data('id')
        let pedido = $(this).data('pedido')
        let nome_cliente = $(this).data('nome')
        // confirmar exclusão
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja realmente excluir o pedido n° " + pedido + " de " + nome_cliente + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/pedidos/excluir/" + id,
                    type: "DELETE",
                    success: function (response) {
                        if (response.status === 'success') {
                            //Alert de sucesso
                            Swal.fire('Excluído!', response.mensagem, 'success');
                            // Recarrega os dados sem reload da página
                            $('#listaPedidos').DataTable().ajax.reload(null, false); 
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

                        Swal.fire('Erro!', 'Não foi possível excluir o pedido.', 'error');
                    }
                });
            }
        })
    });

    //Click para finalizar pedido
    $(document).on('click', '.finalizarPedido', function(e){
        e.preventDefault();
        let id = $(this).data('id');
        let pedido = $(this).data('pedido');
        let nome_cliente = $(this).data('cliente');
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja realmente finalizar o pedido n° " + pedido + " de " + nome_cliente + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, finalizar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/pedidos/finalizar/" + id,
                    type: "POST",
                    success: function (response) {
                        if (response.status === 'success') {
                            //Alert de sucesso
                            Swal.fire('Finalizado!', response.mensagem, 'success');
                            // Recarrega os dados sem reload da página
                            $('#listaPedidos').DataTable().ajax.reload(null, false); 
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

                        Swal.fire('Erro!', 'Não foi possível finalizar o pedido.', 'error');
                    }
                });
            }
        })
    });

    $(document).on('click', '.gerarPDF', function(){
        let id = $(this).data('id');
        window.open('/pedidos/pdf/' + id, '_blank')
    });
});