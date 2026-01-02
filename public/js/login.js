document.addEventListener('DOMContentLoaded', function () {

    const btnLogin = document.getElementById('btnLogin');

    if (btnLogin) {
        btnLogin.addEventListener('click', function () {
            window.location.href = '/home';
        });
    }

});
