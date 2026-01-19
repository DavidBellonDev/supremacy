document.addEventListener('DOMContentLoaded', function () {

    //Botão que abre o cadastro de cliente
    const btnNovoCliente = document.getElementById('novoCliente');
    if (btnNovoCliente) {
        btnNovoCliente.addEventListener('click', function () {
            window.location.href = '/clientes/clientes_cadastro/0';
        });
    }

    //Clique no botão Editar do cliente
    $('#listaClientes').on('click', '.editar', function () {
        let id = $(this).data('id');
        $.ajax({
            url: "/clientes/clientes_cadastro/" + id,
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
                window.location.href = "/clientes/clientes_cadastro/" + id;
            }
        });
    });

    //Clique no botão Excluir do cliente
    $('#listaClientes').on('click', '.excluir', function () {
        let id = $(this).data('id')
        let nome = $(this).data('nome')
        // confirmar exclusão
         Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja realmente excluir o cliente " + nome + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/clientes/excluir/" + id,
                    type: "DELETE",
                    success: function (response) {
                        if (response.status === 'success') {
                            //Alert de sucesso
                            Swal.fire('Excluído!', response.mensagem, 'success');
                            // Recarrega os dados sem reload da página
                            $('#listaClientes').DataTable().ajax.reload(null, false); 
                        }else {
                            //Alert de erro
                            Swal.fire('Erro!', response.mensagem, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Erro!', 'Não foi possível excluir o cliente.', 'error');
                    }
                });
            }
        })
    });

});