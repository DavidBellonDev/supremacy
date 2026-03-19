<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/menu_conteudo.css') ?>">
    <link rel="icon" type="image/svg+xml" href="<?= base_url('img/icon.svg') ?>">
    <title>Home</title>
    <style>
        .progress-bar{
            border-radius: 5px;
            transition: width 1.5s ease-out !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Menu lateral -->
            <aside class="col-md-3 col-lg-2 bg-dark text-white min-vh-100 p-3">
                <?= $this->include('menu/_menu'); ?>
            </aside>
            <!-- Conteúdo principal -->
            <main class="col-md-9 col-lg-10 p-4 conteudo">
                <div class="row">
                    <div class="col-md-9">
                        <h3>Home</h3>
                    </div>
                    <div class="col-md-3 text-end">
                        <label>Bem-vindo(a) <?= session()->get('nome'). " " . session()->get('sobrenome')?></label>
                    </div>
                    <div class="container-fluid mt-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card shadow-sm border-0">
                                    <div class="card-header d-flex justify-content-between bg-dark">
                                        <h5 class="card-title">Vendas</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="text-dark">
                                            R$ <span id="contadorVendas">0</span> (Finalizados)
                                        </h5>
                                        <canvas id="graficoVendas"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="card shadow-sm border-0">
                                    <div class="card-header d-flex justify-content-between bg-dark">
                                        <h5 class="card-title">Pedidos</h5>
                                    </div>
                                    <div class="card-body text-dark">
                                        <!-- Finalizados -->
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between">
                                                <span>Finalizados</span>
                                                <span class="contador" data-valor="<?= $totalDePedidosFinalizados ?>" data-total="<?=  $totalDePedidos ?>"><?= $totalDePedidosFinalizados ?>/<?= $totalDePedidos ?></span>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-success barra-finalizados" 
                                                data-width="<?= ($totalDePedidosFinalizados/$totalDePedidos)*100 ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Em aberto -->
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between">
                                                <span>Vendas em Aberto</span>
                                                <span class="contador" data-valor="<?= $pedidosAtrasadosValor ?>" data-total="<?=  $totalDePedidos ?>"><?= $pedidosAtrasadosValor ?>/<?= $totalDePedidos ?></span>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-primary barra-abertos"
                                                    data-width="<?= ($pedidosAtrasadosValor/$totalDePedidos)*100 ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Orçamentos -->
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between">
                                                <span>Orçamentos</span>
                                                <span><?= $orcamentosAbertosTotal ?>/<?= $totalDePedidos ?></span>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-danger"
                                                   data-width="<?= ($orcamentosAbertosTotal/$totalDePedidos)*100 ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>
                    <div class="container-fluid mt-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card shadow-sm border-0">
                                    <div class="card-header bg-dark">
                                        <h5 class="mb-0">🏆 Produtos que mais vendem</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <?php foreach($topProdutos as $index => $produto): ?>
                                                <?php
                                                    $medalha = '';
                                                    if($index == 0) $medalha = '🥇';
                                                    elseif($index == 1) $medalha = '🥈';
                                                    elseif($index == 2) $medalha = '🥉';
                                                    elseif($index == 3) $medalha = '4ª - ';
                                                ?>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>
                                                        <?= $medalha ?> <?= esc($produto->descricao) ?>
                                                    </span>
                                                    <span class="badge bg-success">
                                                        R$ <?= number_format($produto->total_produtos,2,',','.') ?>
                                                    </span>
                                                </li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm border-0">
                                    <div class="card-header bg-dark">
                                        <h5 class="mb-0">🏆 Clientes que mais compram</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <?php foreach($topClientes as $index => $cliente): ?>
                                                <?php
                                                    $medalha = '';
                                                    if($index == 0) $medalha = '🥇';
                                                    elseif($index == 1) $medalha = '🥈';
                                                    elseif($index == 2) $medalha = '🥉';
                                                    elseif($index == 3) $medalha = '4ª - ';
                                                ?>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>
                                                        <?= $medalha ?> <?= esc($cliente->nome) ?>
                                                    </span>
                                                    <span class="badge bg-success">
                                                        R$ <?= number_format($cliente->total_compras,2,',','.') ?>
                                                    </span>
                                                </li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    //Grafico
    const ctx = document.getElementById('graficoVendas').getContext('2d');

    const gradienteRoxo = ctx.createLinearGradient(0,0,0,400);
    gradienteRoxo.addColorStop(0,'#55f735ff');
    gradienteRoxo.addColorStop(1,'#000000ff');

    const gradienteVermelho = ctx.createLinearGradient(0,0,0,400);
    gradienteVermelho.addColorStop(0,'#e73737ff');
    gradienteVermelho.addColorStop(1,'#000000');

    const meses = <?= json_encode(array_values($meses)) ?>;
    const finalizados = <?= json_encode(array_values($finalizados)) ?>;
    const abertos = <?= json_encode(array_values($abertos)) ?>;

    new Chart(ctx,{
        type:'bar',
        data:{
            labels: meses,
            datasets:[{
                label:'Finalizados',
                data: finalizados,
                backgroundColor: gradienteRoxo,
                borderRadius:6
            },
            {
                label:'Em aberto',
                data: abertos,
                backgroundColor: gradienteVermelho,
                borderRadius:6
            }]
        },
        options: {
            responsive: true,
            animations:{
                x:{
                    from:0
                }
            },
            animation:{
                duration: 3000,
                easing:'easeOutQuart'
            },
            plugins: {
                legend: {
                    position:'bottom',
                    labels:{
                        usePointStyle:true,
                        pointStyle:'rectRounded',
                        padding:20,
                        color:'#374151'
                    }
                },
                tooltip: {
                    backgroundColor:'#111',
                    padding:12,
                    cornerRadius:6,
                    callbacks: {
                        label: function(context){
                            return 'R$ ' + context.raw.toLocaleString('pt-BR',{
                                minimumFractionDigits:2
                            });
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display:false
                    }
                },
                y: {
                    beginAtZero:true,
                    grid: {
                        color:'rgba(0,0,0,0.04)',
                        drawBorder:false
                    },
                    ticks: {
                        callback: function(value){
                            return 'R$ '+value;
                        }
                    }
                }
            }
        }
    });

    function animarValor(id, valorFinal, duracao=2000){
        let inicio = 0;
        const incremento = valorFinal / (duracao / 16);

        function atualizar(){
            inicio += incremento;
            if(inicio >= valorFinal){
                document.getElementById(id).innerText =
                valorFinal.toLocaleString('pt-BR',{minimumFractionDigits:2});
                return;
            }

            document.getElementById(id).innerText =
            inicio.toLocaleString('pt-BR',{minimumFractionDigits:2});

            requestAnimationFrame(atualizar);
        }

        atualizar();
    }
    animarValor("contadorVendas", <?= $totalFinalizados ?>);


    //Barras de progresso
    window.addEventListener('load', function(){

        document.querySelectorAll('.progress-bar').forEach(bar => {
            const width = bar.getAttribute('data-width');

            // força estado inicial
            bar.style.width = '0%';

            // força o navegador aplicar o 0%
            bar.getBoundingClientRect();

            // anima depois
            setTimeout(() => {
                bar.style.width = width + '%';
            }, 300);
        });

    });

    function animarContador(el, valorFinal, totalPedidos, duracao=1000){
        let inicio = 0;
        const incremento = valorFinal / (duracao / totalPedidos);

        function atualizar(){
            inicio += incremento;

            if(inicio >= valorFinal){
                el.innerText = valorFinal + "/" + totalPedidos;
                return;
            }

            el.innerText = Math.floor(inicio) + "/" + totalPedidos;
            requestAnimationFrame(atualizar);
        }

        atualizar();
    }

    document.querySelectorAll('.contador').forEach(el => {
        const valor = parseInt(el.getAttribute('data-valor'));
        const totalpedidos = parseInt(el.getAttribute('data-total'));
        animarContador(el, valor, totalpedidos);
    });

</script>
</body>
</html>