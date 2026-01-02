<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('css/login.css') ?>">
    <link rel="icon" type="image/svg+xml" href="img/icon.svg">
    <title>Cadastre-se</title>
</head>
<body>
    <div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
        <div class="row w-100 justify-content-center" >
            <div class="col-4 p-4" style="background-color:#fff; border-radius: 30px; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5);">
                <div class="row d-flex justify-content-center mt-3">
                    <img src="img/usuario.svg" width="100" height="100">
                    <h3 class="text-center">Cadastre-se</h3>
                </div>
                <div class="row justify-content-center">
                    <div class="col-10 mt-3">
                        <div class="input-group mb-1">
                            <span class="input-group-text"> <i class="bi bi-house-door-fill"></i></span>
                            <input type="text" class="form-control" placeholder="CNPJ da Empresa">
                        </div>
                        <div class="input-group mb-1">
                            <span class="input-group-text"> <i class="bi bi-person-fill"></i></span>
                            <input type="text" class="form-control" placeholder="Nome">
                        </div>
                        <div class="input-group mb-1">
                            <span class="input-group-text"> <i class="bi bi-person-fill"></i></span>
                            <input type="text" class="form-control" placeholder="Sobrenome">
                        </div>
                        <div class="input-group mb-1">
                            <span class="input-group-text"> <i class="bi bi-person-fill"></i></span>
                            <input type="text" class="form-control" placeholder="Usuário">
                        </div>
                        <div class="input-group mb-1">
                            <span class="input-group-text">@</span>
                            <input type="text" class="form-control" placeholder="Email">
                        </div>
                        <div class="input-group mb-1">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" placeholder="Senha">
                        </div>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" placeholder="Confirmar Senha">
                        </div>
                        <div class="mt-3">
                            <button class="form-control btn-danger">Cadastrar</button>
                        </div>
                        <div class="text-center mt-3 mb-3">
                            <a href="/" class="text-decoration-none text-secondary fw-semibold">Supremacy.com.br</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>