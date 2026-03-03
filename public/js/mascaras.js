$(document).ready(function () {

    //Colocar mascaras nos campos de valor
    iniciarMascaras();

    //Mascara monetaria
    $('.money').mask('000.000.000.000.000,00', {
        reverse: true
    });

    //Mascara estoque
    $('.estoque').mask('000.000.000.000.000,00', {
        reverse: true
    });
});

//Formatar os valores recebidos 
function formatarParaBR(valor) {
    if (!valor) return '';
    return parseFloat(valor)
        .toFixed(2)
        .replace('.', ',')
        .replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

// Receber os valores, formatar e inserir nos devidos campos
function iniciarMascaras() {
    let preco = $('#preco').data('preco');
    $('#preco').val(formatarParaBR(preco));

    let custo = $('#custo').data('custo');
    $('#custo').val(formatarParaBR(custo));

    let estoque_minimo = $('#estoque_minimo').data('estoque_minimo');
    $('#estoque_minimo').val(formatarParaBR(estoque_minimo));

    let estoque_atual = $('#estoque_atual').data('estoque_atual');
    $('#estoque_atual').val(formatarParaBR(estoque_atual));

}

//Retirar a mascara monetária dos campos
function removerMascaras(){
    $('.money, .estoque').each(function () {
        let valor = $(this).val();
        valor = valor.replace(/\./g, '').replace(',', '.');
        $(this).val(valor);
    });
}