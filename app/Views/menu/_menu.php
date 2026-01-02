<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" type="image/svg+xml" href="img/icon.svg">
    <title>Supremacy</title>

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(
                135deg,
                #37b0e7ff,
                #652de9ff,
                #55f735ff,
                #f32b2bff
            );
            background-size: 300% 300%;
            animation: gradientMove 10s ease infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body>
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px; height: 100%">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <img src="img/icon.svg" width="50" height="50">
            <span class="fs-4">Supremacy</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="<?= base_url('home') ?>" 
                    class="nav-link text-white <?= service('uri')->getSegment(1) === 'home' ? 'active' : '' ?>">
                    <i class="bi bi-house-door-fill"></i><span class="ms-2">Home</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('clientes') ?>" 
                    class="nav-link text-white <?= service('uri')->getSegment(1) === 'clientes' ? 'active' : '' ?>">
                    <i class="bi bi-people-fill"></i><span class="ms-2">Clientes</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('vendas') ?>" 
                    class="nav-link text-white <?= service('uri')->getSegment(1) === 'vendas' ? 'active' : '' ?>">
                    <i class="bi bi-cart-plus-fill"></i><span class="ms-2">Vendas</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('produtos') ?>" 
                    class="nav-link text-white <?= service('uri')->getSegment(1) === 'produtos' ? 'active' : '' ?>">
                    <i class="bi bi-box-seam-fill"></i><span class="ms-2">Produtos</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('configuracoes') ?>" 
                    class="nav-link text-white <?= service('uri')->getSegment(1) === 'configuracoes' ? 'active' : '' ?>">
                    <i class="bi bi-gear-fill"></i><span class="ms-2">Configurações</span>
                </a>
            </li>
        </ul>
    </div>
</body>
</html>
