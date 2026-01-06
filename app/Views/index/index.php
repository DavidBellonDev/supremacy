<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" type="image/svg+xml" href="img/icon.svg">
        <link rel="stylesheet" href="<?= base_url('css/index.css') ?>">
    <title>Supremacy</title>
</head>
<body class="bg-dark">
    <nav class="navbar navbar-dark bg-dark navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#topo">Sobre Nós</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#servicos">Serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#planos">Planos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contatos">Contatos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="bg-carousel position-relative">
    <!-- Carrossel -->
    <div id="bgCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/img-index.jpg" class="d-block w-100 bg-img">
            </div>
            <div class="carousel-item">
                <img src="img/img2-index.jpg" class="d-block w-100 bg-img">
            </div>
            <div class="carousel-item">
                <img src="img/img3-index.jpg" class="d-block w-100 bg-img">
            </div>
        </div>
    </div>
    <!-- Overlay escuro -->
    <div class="overlay"></div>
    <!-- Conteúdo por cima -->
    <div id="topo" class="row"></div>
        <div class="content text-center text-light">
            <div class="mt-3">
                <img src="img/icon.svg" width="300" alt="">
            </div>
            <h1 class="text-center">Supremacy</h1>
            <h3>Simplicidade para te ajudar a crescer.</h3>
        </div>
    </div>
    <div class="container-fluid" style="background-color: #37b0e7ff;">
        <div class="row">
            <h2 class="text-center mt-5">Quem somos?</h2>
            <div class="col-6 mt-3 mb-5">
                <div class="d-flex justify-content-center">
                    <img class="sombra-caixa" src="img/img4-index.jpg" width="350">
                </div>
            </div>
            <div class="container col-6 mb-5 d-flex justify-content-center align-items-center text-center">
                <div class="d-flex justify-content-center">
                    <h4 class="text-center">Criada em 2025, a Supremacy tem como objetivo ajudar os empreendedores que estão começando sua jornada. Assim como o martelo é uma ferramenta simples mas que participa em toda grande construção, a Supremacy deseja aproveitar a simplicidade para te ajudar a construir sua história.<br><br> Significa isso que a Supremacy não vai evoluir? Jamais! Estamos dispostos a crescer junto com você, a atender novas necessidades da sua empresa sem perder aquele toque de simplicidade para que o trabalho seja tranquilo e produtivo.</h4> 
                </div>
            </div> 
        </div>       
    </div>
    <div id="servicos" class="container-fluid" style="background-color: #652de9ff;">
        <div class="row">
            <h2 class="text-center text-light mt-5">O que oferecemos?</h2>
            <h4 class="text-center text-light mt-5">Nós oferecemos facilidade para o seu dia, tranquilidade para seu negócio e organização para a sua vida</h4>
            <div class="row mt-5 mb-5 justify-content-center">
                <div class="col-3 m-2 d-flex flex-column align-items-center contorno">
                    <img src="img/carrinho.svg" width="150" alt="">
                    <h3 class="text-light">Vendas</h3>
                    <h6 class="text-center text-light">Cadastre e controle suas vendas diariamente com poucos cliques</h6>
                </div>
                <div class="col-3 m-2 d-flex flex-column align-items-center contorno">
                    <img src="img/estoque.svg" width="150" alt="">
                    <h3 class="text-light">Estoque</h3>
                    <h6 class="text-center text-light">Controle seu estoque de produtos de forma organizada para sempre atender seus clientes</h6>

                </div>
                <div class="col-3 m-2 d-flex flex-column align-items-center contorno">
                    <img src="img/relatorio.svg" width="150" alt="">
                    <h3 class="text-light">Relatórios</h3>
                    <h6 class="text-center text-light">Gere relatórios para ter a empresa toda na palma da mão</h6>

                </div>
            </div>
        </div>
    </div>
        <div id="planos" class="container-fluid" style="background-color: #f32b2bff;">
        <div class="row">
            <h2 class="text-center text-light mt-5">Por que escolher a Supremacy?</h2>
            <div class="container col-6 mb-5 d-flex justify-content-center align-items-center text-center">
                <div class="container">
                    <div class="d-flex justify-content-center">
                        <h5 class="text-center text-light ">Além de tudo que falamos sobre objetividade e organização, você vai agregar valor ao seu negócio. Nosso sistema vale seu investimento que será baixinho. Nós te ajudamos realmente de todas as formas, até nessa hora. Economia e qualidade, quem não quer isso?</h5> 
                    </div>
                    <div class="row">
                        <div class="card col-4">
                            <h5 class="card-header">Mensal</h5>
                            <div class="card-body">
                                <h5 class="card-title">R$ 29,90</h5>
                                <ul>
                                    <li>Dois Usuários</li>
                                    <li>Cad. Produtos</li>
                                    <li>Cad. Vendas</li>
                                </ul>
                                <a href="#" class="btn btn-primary">Assinar</a>
                            </div>
                        </div>
                        <div class="card col-4">
                            <h5 class="card-header">Semestral</h5>
                            <div class="card-body">
                                <h5 class="card-title">R$ 169,90</h5>
                                <ul>
                                    <li>Cinco Usuários</li>
                                    <li>Cad. Produtos</li>
                                    <li>Cad. Vendas</li>
                                    <li>Cad. Contas</li>
                                </ul>
                                <a href="#" class="btn btn-primary">Assinar</a>
                            </div>
                        </div>
                        <div class="card col-4">
                            <h5 class="card-header">Anual</h5>
                            <div class="card-body">
                                <h5 class="card-title">R$ 319,90</h5>
                                <ul>
                                    <li>Usuários Ilimitados</li>
                                    <li>Cad. Produtos</li>
                                    <li>Cad. Vendas</li>
                                    <li>Cad. Contas</li>
                                    <li>Relatórios</li>
                                </ul>
                                <a href="#" class="btn btn-primary">Assinar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-6 mt-3 mb-5">
                <div class="d-flex justify-content-center">
                    <img class="sombra-caixa" src="img/img5-index.jpg" width="350">
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <img class="sombra-caixa" src="img/img6-index.jpg" width="350">
                </div>
            </div>
        </div>
    </div>
    <div id="contatos" class="container-fluid" style="background-color: #55f735ff;">
        <div class="row">
            <h2 class="text-center mt-5">Fale conosco</h2>
            <div class="container col-6 mb-5 d-flex justify-content-center align-items-center text-center">
                <div class="d-flex justify-content-center">
                    <h4 class="text-center text-dark">Supremacy, pronta para te atender sempre que precisar!</h4> 
                </div>
            </div>
            <div class="col-6 mt-3 mb-5">
                <div class="row mt-5 mb-5 justify-content-center">
                    <div class="col-3 d-flex flex-column align-items-center ">
                        <img src="img/instagram.svg" width="50" alt="">
                        <h6>@_cap_david</h6>
                    </div>
                    <div class="col-3 d-flex flex-column align-items-center ">
                        <img src="img/facebook.svg" width="50" alt="">
                        <h6>David Bellon</h6>
                    </div>
                </div>
                <div class="row mt-5 mb-5 justify-content-center">
                    <div class="col-3 d-flex flex-column align-items-center ">
                        <img src="img/whatsapp.svg" width="50" alt="">
                        <h6>(11)9****-**86</h6>
                    </div>
                    <div class="col-3 d-flex flex-column align-items-center ">
                        <img src="img/github.svg" width="50" alt="">
                        <h6>DavidBellonDev</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="card bg-dark">
            <div class="card-header">
                <p class="text-light text-center">&copy; 2026 Supremacy. Todos os direitos reservados</p>
                <p class="text-light text-center"> Desenvolvido por David Bellon</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

</body>
</html>