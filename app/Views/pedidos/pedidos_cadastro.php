<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/menu_conteudo.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/pedidos_cadastro.css') ?>">
    <link rel="icon" type="image/svg+xml" href="img/icon.svg">
    <title>Pedido - Cadastro</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
                <div class="row mb-4">
                    <div class="col-9">
                        <h3>Pedido</h3>
                    </div>
                    <div class="col-3">
                         <button class="form-control btn btn-danger">Salvar Pedido</button>
                    </div>
                </div>
                <ul class="nav nav-tabs">
                    <li class="nav-item ">
                        <a class="nav-link text-white active" data-bs-toggle="tab" aria-current="page" href="#principal">Principal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" data-bs-toggle="tab" href="#itens">Itens</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade <?php if ($aba_ativa == 'principal') echo 'show active'; ?>" id="principal">
                        <?= form_open('pedidos/cadastrar', ['id' => 'form'], ['id' => "1" ]) ?>
                            <?= csrf_field() ?>
                            <div class="row mt-3">
                                <div class="form-group col-md-6">
                                    <label for="cliente" class="form-control-label">Cliente</label>
                                    <input type="text" name="cliente" id="cliente" placeholder="Cliente" class="form-control" >
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="status" class="form-control-label">Status</label>
                                    <input type="text" name="status" id="status" placeholder="Status" class="form-control" >
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="pedido" class="form-control-label">Pedido</label>
                                    <input type="text" name="pedido" id="pedido" placeholder="Pedido" class="form-control" >
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="form-group col-md-4">
                                    <label for="endereco" class="form-control-label">Endereço</label>
                                    <input type="text" name="endereco" id="endereco" placeholder="Endereço" class="form-control" >
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="numero" class="form-control-label">Número</label>
                                    <input type="text" name="numero" id="numero" placeholder="N°" class="form-control" >
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="complemento" class="form-control-label">Complemento</label>
                                    <input type="text" name="complemento" id="complemento" placeholder="Complemento" class="form-control" >
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cidade" class="form-control-label">Cidade</label>
                                    <input type="text" name="cidade" id="cidade" placeholder="Cidade" class="form-control" >
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="estado" class="form-control-label">Estado</label>
                                    <input type="text" name="estado" id="estado" placeholder="Estado" class="form-control" >
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="form-group col-md-6">
                                    <label for="observacao" class="form-control-label">Observação</label>
                                    <input type="text" name="observacao" id="observacao" placeholder="Observação" class="form-control" >
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="desconto" class="form-control-label">Desconto</label>
                                    <input type="text" name="desconto" id="desconto" placeholder="Desconto" class="form-control" >
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="total" class="form-control-label">Total</label>
                                    <input type="text" name="total" id="total" placeholder="Total" class="form-control" >
                                </div>
                            </div>
                        <?= form_close(); ?>
                    </div>
                    <div class="tab-pane fade <?php if ($aba_ativa == 'itens') echo 'show active'; ?>" id="itens">
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>