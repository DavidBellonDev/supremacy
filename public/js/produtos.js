document.addEventListener('DOMContentLoaded', function () {

    //Botão que abre o cadastro de produto
    const novoProduto = document.getElementById('novoProduto');
    if (novoProduto) {
        novoProduto.addEventListener('click', function () {
            window.location.href = '/produtos/produtos_cadastro';
        });
    }

});