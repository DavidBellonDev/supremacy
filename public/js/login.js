document.addEventListener('DOMContentLoaded', function () {

    //Botão que abre a tela Home (Inicial)
    const btnLogin = document.getElementById('btnLogin');
    if (btnLogin) {
        btnLogin.addEventListener('click', function () {
            $.ajax({
                type: 'post',
                url: $('#formLogar').attr('action'), // Rota definida no Routes.php
                data: $('#formLogar').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso',
                            text: response.mensagem 
                        }).then(() => {
                            window.location.href = "/home";
                        });
                    }else {
                         Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: response.mensagem 
                        });
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
    }

});
