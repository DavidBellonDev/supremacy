<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('css/login.css') ?>">
    <link rel="icon" type="image/svg+xml" href="img/icon.svg">
    <title>Cadastre sua Empresa</title>
</head>
<body>
    <div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
        <div class="row w-100 justify-content-center" >
            <div class="col-4 p-4" style="background-color:#fff; border-radius: 30px; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5);">
                <div class="row d-flex text-center mt-3">
                    <i class="bi bi-house-door-fill" style="font-size: 75px;"></i>
                    <h3 class="text-center">Cadastre sua Empresa</h3>
                </div>
                <div class="row justify-content-center">
                    <div class="col-10 mt-3">
                        <?= form_open('index/salvar_empresa', ['id' => 'formEmpresa']) ?>
                            <?= csrf_field() ?>
                            <div class="input-group mb-1">
                                <span class="input-group-text"><i class="bi bi-house-door-fill"></i></span>
                                <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome Empresa">
                                <input type="hidden" name="num_pedido" value="1">
                            </div>
                            <div class="input-group mb-1">
                                <span class="input-group-text"><i class="bi bi-house-door-fill"></i></span>
                                <input type="text" name="cnpj" id="cnpj" class="form-control" placeholder="CNPJ">
                            </div>
                            <div class="input-group mb-1">
                                <span class="input-group-text"><i class="bi bi-house-door-fill"></i></span>
                                <input type="text" name="cpf" id="cpf" class="form-control" placeholder="CPF">
                            </div>
                            <div class="input-group mb-1">
                                <span class="input-group-text"> <i class="bi bi-telephone-fill"></i></span>
                                <input type="text" name="telefone" id="telefone" class="form-control" placeholder="Telefone">
                            </div>
                            <div class="input-group mb-1">
                                <span class="input-group-text"><i class="bi bi-phone-fill"></i></span>
                                <input type="text" name="celular" id="celular" class="form-control" placeholder="Celular">
                            </div>
                            <div class="input-group mb-1">
                                <span class="input-group-text">@</span>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="input-group mb-1">
                                <span class="input-group-text"> <i class="bi bi-person-fill"></i></span>
                                <input type="text" name="admin" id="admin" class="form-control" placeholder="Nome do Administrador">
                            </div>
                        <?= form_close() ?>    
                        <div class="mt-3">
                            <button id="cadastrarEmpresa" class="form-control btn-danger">Cadastrar</button>
                        </div>
                        <div class="text-center mt-3 mb-3">
                            <a href="/" class="text-decoration-none text-secondary fw-semibold">Supremacy.com.br</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Mascaras -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url('js/empresa_cadastro.js') ?>"></script> <!-- Js Cadastro -->
</body>
</html>