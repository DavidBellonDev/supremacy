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
        $.ajax({
            url: "/pedidos/pedidos_cadastro/" + id,
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: response.mensagem
                    });
                }
            },
            error: function(xhr) {
                // Se não for JSON, significa que retornou a view → redireciona
                window.location.href = "/pedidos/pedidos_cadastro/" + id;
            }
        });
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
                        }else {
                            //Alert de erro
                            Swal.fire('Erro!', response.mensagem, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Erro!', 'Não foi possível excluir o pedido.', 'error');
                    }
                });
            }
        })
    });
});