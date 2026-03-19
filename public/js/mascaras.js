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
    let preco = $('#preco').val();
    $('#preco').val(formatarParaBR(preco));

    let custo = $('#custo').val();
    $('#custo').val(formatarParaBR(custo));

    let estoque_minimo = $('#estoque_minimo').val();
    $('#estoque_minimo').val(formatarParaBR(estoque_minimo));

    let estoque_atual = $('#estoque_atual').val();
    $('#estoque_atual').val(formatarParaBR(estoque_atual));

    let desconto = $('#desconto').val();
    $('#desconto').val(formatarParaBR(desconto));

    let total = $('#total').val();
    $('#total').val(formatarParaBR(total));

    let valor = $('#valor_item').val();
    $('#valor_item').val(formatarParaBR(valor));

    let quantidade = $('#quantidade_item').val();
    $('#quantidade_item').val(formatarParaBR(quantidade));

    let desconto_item = $('#desconto_item').val();
    $('#desconto_item').val(formatarParaBR(desconto_item));

    let total_item = $('#total_item').val();
    $('#total_item').val(formatarParaBR(total_item));
}

//Retirar a mascara monetária dos campos
function removerMascaras(){
    $('.money, .estoque').each(function () {
        let valor = $(this).val();
        valor = valor.replace(/\./g, '').replace(',', '.');
        $(this).val(valor);
    });
}