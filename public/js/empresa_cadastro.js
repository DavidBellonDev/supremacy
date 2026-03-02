$(document).ready(function(){

    //Máscaras para campo CPF, CNPJ, CEP, Telefone e Celular
    // CPF
    $('#cpf').mask('000.000.000-00');
    // CNPJ
    $('#cnpj').mask('00.000.000/0000-00');
    // Telefone fixo
    $('#telefone').mask('(00) 0000-0000');
    // Celular (com 9 dígitos)
    $('#celular').mask('(00) 00000-0000');

    // Click para cadastrar a nova empresa
    $('#cadastrarEmpresa').on('click', function (e) {
        e.preventDefault();
        //Retirar a máscara dos campos...
         $('#cpf, #cnpj, #telefone, #celular').unmask();

        $.ajax({
            type: 'post',
            url: $('#formEmpresa').attr('action'), // Rota definida no Routes.php
            data: $('#formEmpresa').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso',
                        text: response.mensagem + " Você tem um novo usuário para acessar o sistema. Anote o nome dele e senha criados. Eles poderão ser alterados por você assim que desejar. Usuário: " + response.usuario + " Senha: " + response.senha
                    }).then(() => {
                        window.location.href = "/login";
                    });
                }else {
                    let erros = '';
                    $.each(response.errors, function(campo, erro) {
                        erros += erro + '\n';
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: erros
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
});