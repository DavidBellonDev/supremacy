document.addEventListener('DOMContentLoaded', function () {

    //Botão que abre o cadastro de pedidos
    const novoPedido = document.getElementById('novoPedido');
    if (novoPedido) {
        novoPedido.addEventListener('click', function () {
            window.location.href = '/pedidos/pedidos_cadastro';
        });
    }

});