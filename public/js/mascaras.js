$(document).ready(function () {

    //Mascara monetaria
    $('.money').mask('000.000.000.000.000,00', {
        reverse: true
    });

    //Mascara estoque
    $('.estoque').mask('000.000.000.000.000,00', {
        reverse: true
    });
});