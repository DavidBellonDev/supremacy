$(document).ready(function(){

    // Click para recuperar senha
    $('#salvarNovaSenha').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: $('#formSalvarNovaSenha').attr('action'), // Rota definida no Routes.php
            data: $('#formSalvarNovaSenha').serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success'){
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso',
                        text: response.mensagem
                    });
                }else{
                    if(response.status === 'errorSenhas'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: response.mensagem
                        });
                    }else if(response.status === 'error'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: response.mensagem
                        });
                    }
                } 
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