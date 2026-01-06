document.addEventListener('DOMContentLoaded', function () {

    //Botão que abre o cadastro de cliente
    const btnNovoCliente = document.getElementById('novoCliente');
    if (btnNovoCliente) {
        btnNovoCliente.addEventListener('click', function () {
            window.location.href = '/clientes/clientes_cadastro';
        });
    }

});