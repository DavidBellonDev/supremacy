document.addEventListener('DOMContentLoaded', function () {

    //Botão que abre o cadastro de produto
    const novoProduto = document.getElementById('novoProduto');
    if (novoProduto) {
        novoProduto.addEventListener('click', function () {
            window.location.href = '/produtos/produtos_cadastro/0';
        });
    }

    //Botão para Editar o Produto
    $('#listaProdutos').on('click', '.editar', function () {
        let id = $(this).data('id');
        $.ajax({
            url: "/produtos/produtos_cadastro/" + id,
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
                window.location.href = "/produtos/produtos_cadastro/" + id;
            }
        });
    });


    //Botão para Excluir o Produto
    $('#listaProdutos').on('click', '.excluir', function () {
        let id = $(this).data('id')
        let descricao = $(this).data('descricao')
        // confirmar exclusão
         Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja realmente excluir o produto " + descricao + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/produtos/excluir/" + id,
                    type: "DELETE",
                    success: function (response) {
                        if (response.status === 'success') {
                            //Alert de sucesso
                            Swal.fire('Excluído!', response.mensagem, 'success');
                            // Recarrega os dados sem reload da página
                            $('#listaProdutos').DataTable().ajax.reload(null, false); 
                        }
                    },
                    error: function (xhr) {
                        if(!xhr.responseJSON){
                            Swal.fire('Erro', 'Falha na comunicação com o servidor.', 'error');
                            return;
                        }

                        const response = xhr.responseJSON;
                        //Erro de Regra/Sistema
                        if(response.errors && response.errors._global){
                            Swal.fire('Erro', response.errors._global, 'error');
                            return;
                        }
                        
                        Swal.fire('Erro!', 'Não foi possível excluir o produto.', 'error');
                    }
                });
            }
        })
    });
});