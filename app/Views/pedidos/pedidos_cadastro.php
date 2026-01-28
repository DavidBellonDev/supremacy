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
<style>
.ui-autocomplete {
    z-index: 9999;
    background: #fff;
    border: 1px solid #ccc;
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
                <div class="row mb-4">
                    <div class="col-9">
                        <h3>Pedido</h3>
                    </div>
                    <div class="col-3">
                         <button id="salvarPedido" class="form-control btn btn-danger">Salvar Pedido</button>
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
                        <?= form_open('pedidos/salvar', ['id' => 'formPedido']) ?>
                            <?= csrf_field() ?>
                            <div class="row mt-3">
                                <div class="form-group col-md-6">
                                    <label for="nome_cliente" class="form-control-label">Cliente</label>
                                    <input type="text" id="nome_cliente" name="nome_cliente" class="form-control" placeholder="Digite o nome ou CPF" value="<?= $pedido->nome_cliente ?? '' ?>">
                                    <input type="hidden" id="id" name="id" value="<?= $pedido->id ?? '' ?>">
                                    <input type="hidden" id="id_cliente" name="id_cliente" value="<?= $pedido->id_cliente ?? '' ?>">
                                    <input type="hidden" id="id_empresa" name="id_empresa" value="1">
                                    <input type="hidden" id="cpf_cliente" name="cpf_cliente" value="<?= $pedido->cpf_cliente ?? '' ?>">
                                    <input type="hidden" id="cnpj_cliente" name="cnpj_cliente" value="<?= $pedido->cnpj_cliente ?? '' ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="status" class="form-control-label">Status</label>
                                    <select name="status" id="status" placeholder="Status" class="form-select">
                                        <?php foreach ($status as $sigla => $status_atual): ?>
                                        <option value="<?= $sigla ?>" <?= ($pedido->status ?? '') === $sigla ? 'selected' : '' ?>><?= $status_atual ?></option>
                                    <?php endforeach; ?> 
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="pedido" class="form-control-label">Pedido</label>
                                    <input type="text" name="pedido" id="pedido" placeholder="Pedido" class="form-control" value="<?= $pedido->pedido ?? '' ?>">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="form-group col-md-4">
                                    <label for="endereco" class="form-control-label">Endereço</label>
                                    <input type="text" name="endereco_cliente" id="endereco_cliente" placeholder="Endereço" class="form-control" value="<?= $pedido->endereco_cliente ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="numero" class="form-control-label">Número</label>
                                    <input type="text" name="numero_cliente" id="numero_cliente" placeholder="N°" class="form-control" value="<?= $pedido->numero_cliente ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="complemento" class="form-control-label">Complemento</label>
                                    <input type="text" name="complemento_cliente" id="complemento_cliente" placeholder="Complemento" class="form-control" value="<?= $pedido->complemento_cliente ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cidade" class="form-control-label">Cidade</label>
                                    <input type="text" name="cidade_cliente" id="cidade_cliente" placeholder="Cidade" class="form-control" value="<?= $pedido->cidade_cliente ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="estado" class="form-control-label">Estado</label>
                                    <input type="text" name="estado_cliente" id="estado_cliente" placeholder="Estado" class="form-control" value="<?= $pedido->estado_cliente ?? '' ?>" readonly>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="form-group col-md-6">
                                    <label for="observacao" class="form-control-label">Observação</label>
                                    <input type="text" name="observacao" id="observacao" placeholder="Observação" class="form-control" value="<?= $pedido->observacao ?? '' ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="desconto" class="form-control-label">Desconto</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                        <input type="text" name="desconto" id="desconto" placeholder="Desconto" class="form-control money" value="<?= $desconto ?? '' ?>">
                                    </div>
                                    
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="total" class="form-control-label">Total</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                        <input type="text" name="total" id="total" placeholder="Total" class="form-control money" value="<?= $total ?? '' ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        <?= form_close(); ?>
                    </div>
                    <div class="tab-pane fade <?php if ($aba_ativa == 'itens') echo 'show active'; ?>" id="itens">
                        <table id="listaItens" class="table text-light" >
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Valor</th>
                                    <th>Quantidade</th>
                                    <th>Desconto</th>
                                    <th>Total</th> 
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>   
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Mascara Monetaria -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="<?= base_url('js/mascaras.js') ?>"></script> <!-- Js de Mascaras diversas -->
    <script src="<?= base_url('js/pedidos_cadastro.js') ?>"></script> <!-- Js Cadastro de Pedidos -->
</body>
</html>