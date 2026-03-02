$(document).ready(function(){

    // Click para recuperar senha
    $('#recuperarSenha').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: $('#formRecuperarSenha').attr('action'), // Rota definida no Routes.php
            data: $('#formRecuperarSenha').serialize(),
            dataType: 'json',
            success: function(response) {
                Swal.fire({
                    icon: 'info',
                    title: 'Sucesso',
                    text: response.mensagem
                }).then(() => {
                    window.location.href = "/login";
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Falha na comunicação com o servidor.'
                });
            }
        });
    });
});