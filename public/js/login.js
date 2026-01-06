document.addEventListener('DOMContentLoaded', function () {

    //Botão que abre a tela Home (Inicial)
    const btnLogin = document.getElementById('btnLogin');
    if (btnLogin) {
        btnLogin.addEventListener('click', function () {
            window.location.href = '/home';
        });
    }

});
