<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/menu_conteudo.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/pedidos_cadastro.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/datatable.css') ?>">
    <link rel="icon" type="image/svg+xml" href="img/icon.svg">
    <title>Pedido - Cadastro</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- DataTables Bootstrap 5 CSS -->
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<style>
.ui-autocomplete {
    z-index: 2000 !important;
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
                                        <input type="hidden" id="total_fixo" name="total_fixo" value="<?= $total_itens ?? '' ?>">
                                    </div>
                                </div>
                            </div>
                        <?= form_close(); ?>
                    </div>
                    <div class="tab-pane fade <?php if ($aba_ativa == 'itens') echo 'show active'; ?>" id="itens">
                        <div class="col-12">
                            <table id="listaItens" class="table text-light w-100 mt-3" >
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
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Novo Item -->
    <div class="modal fade" id="modalNovoItem" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Item do Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?= form_open('itens/salvar', ['id' => 'formItem']) ?>
                        <?= csrf_field() ?>
                        <input type="hidden" id="id_item" name="id_item">
                        <input type="hidden" name="id_pedido" id="id_pedido" value="<?= $pedido->id ?? '' ?>">
                        <input type="hidden" name="id_empresa" id="id_empresa" value="<?= $pedido->id_empresa ?? '' ?>">
                        <input type="hidden" name="id_produto" id="id_produto" value="0">
                        <input type="hidden" name="id_usuario" id="id_usuario" value="1">
                        <input type="hidden" name="nome_usuario" id="nome_usuario" value="David">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Produto</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="descricao_produto" name="descricao_produto" class="form-control" placeholder="Produto" value="<?= $item->descricao_produto ?? '' ?>">
                                    <button class="btn btn-outline-secondary" type="button" id="editar_produto">Editar</button>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Valor</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                    <input type="text" name="valor" id="valor_item" class="form-control money" value="0,00" required>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Quantidade</label>
                                <input type="text" name="quantidade" id="quantidade_item" class="form-control money" value="1,00" min="1" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Desconto</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                    <input type="text" name="desconto" id="desconto_item" class="form-control money" value="0,00">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 mb-3">
                                <label>Observação</label>
                                <input type="text" name="observacao" id="observacao_item" placeholder="Observação" class="form-control">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Total</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                    <input type="text" name="total" id="total_item" class="form-control money" value="0,00" readonly>
                                </div>
                            </div>
                        </div>
                    <?= form_close(); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-success" id="salvarItem">
                        Salvar Item
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery (primeiro de tudo) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet"
        href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <!-- jQuery Mask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Seus scripts (SEMPRE por último) -->
    <script src="<?= base_url('js/mascaras.js') ?>"></script>
    <script src="<?= base_url('js/pedidos_cadastro.js') ?>"></script>

    <script>
        $(document).ready(function () {
            var id = $('#id').val();
            $('#listaItens').DataTable({
                ajax: "<?= site_url("itens/listar/") ?>" + id,
                responsive: false, // melhor dentro de tab
                autoWidth: false,
                columns: [
                    { data: 'descricao_produto' },
                    { data: 'valor_tabela',
                        render: function(data, type){
                            // Ordenação, busca e exportação usam número puro
                            if (type !== 'display') {
                                return data;
                            }
                            // Exibição formatada
                            return new Intl.NumberFormat('pt-BR', {
                                style: 'currency',
                                currency: 'BRL',
                            }).format(data);
                        }
                    },
                    { data: 'quantidade_tabela',
                        render: function(data, type){
                            // Ordenação, busca e exportação usam número puro
                            if (type !== 'display') {
                                return data;
                            }
                            // Exibição formatada
                            return new Intl.NumberFormat('pt-BR', {
                                minimumFractionDigits: 2
                            }).format(data);
                        }
                    },
                    { data: 'desconto_tabela',
                        render: function(data, type){
                            // Ordenação, busca e exportação usam número puro
                            if (type !== 'display') {
                                return data;
                            }
                            // Exibição formatada
                            return new Intl.NumberFormat('pt-BR', {
                                style: 'currency',
                                currency: 'BRL',
                                minimumFractionDigits: 2
                            }).format(data);
                        }
                    },
                    { data: 'total_tabela',
                        render: function(data, type){
                            // Ordenação, busca e exportação usam número puro
                            if (type !== 'display') {
                                return data;
                            }
                            // Exibição formatada
                            return new Intl.NumberFormat('pt-BR', {
                                style: 'currency',
                                currency: 'BRL',
                                minimumFractionDigits: 2
                            }).format(data);
                        }
                    },
                    {data: 'id', //Botões de Ação
                        render: function (data, type, row) {
                            return `
                                <button class="btn btn-sm btn-warning editar" id="editarItem" data-id="${data}" data-descricao_produto="${row.descricao_produto}" data-valor_modal="${row.valor_modal}" data-quantidade_modal="${row.quantidade_modal}" data-desconto_modal="${row.desconto_modal}" data-observacao="${row.observacao}" data-total_modal="${row.total_modal}">
                                    <i class="bi bi-pencil-fill"></i> Editar
                                </button>
                                <button class="btn btn-sm btn-danger excluir" data-id="${data}" data-descricao_produto="${row.descricao_produto}" data-pedido="${row.pedido}">
                                    <i class="bi bi-trash-fill"></i> Excluir
                                </button>
                            `;
                        }
                    }
                ],
                columnDefs: [
                    { className: "text-center", targets: "_all" }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json'
                },
                info: false,
                dom:
                    "<'row'<'col-md-12'f>>" +
                    "<'row'<'col-12'tr>>" +
                    "<'row mt-2'<'col-md-6 novoItem'><'col-md-6'p>>",
                initComplete: function () {
                    $('.novoItem').html(`
                        <button type="button" class="btn btn-success" id="novoItem">
                            <i class="bi bi-plus-circle"></i> Novo Item
                        </button>
                    `);
                }
            });
            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function () {
                $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
            });
        });
    </script>

</body>
</html>