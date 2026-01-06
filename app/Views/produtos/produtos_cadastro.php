<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/menu_conteudo.css') ?>">
    <link rel="icon" type="image/svg+xml" href="img/icon.svg">
    <title>Produtos - Cadastro</title>
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
                        <h3>Produto</h3>
                    </div>
                    <div class="col-3">
                         <button class="form-control btn btn-danger">Salvar Produto</button>
                    </div>
                </div>
                <?= form_open('produtos/cadastrar', ['id' => 'form'], ['id' => "1" ]) ?>
                    <?= csrf_field() ?>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="codigo" class="form-control-label">Código</label>
                                <input type="text" name="codigo" id="codigo" placeholder="Código" class="form-control" >
                            </div>
                            <div class="form-group col-md-6">
                                <label for="descricao" class="form-control-label">Descrição</label>
                                <input type="text" name="descricao" id="descricao" placeholder="Descrição" class="form-control" >
                            </div>
                            <div class="form-group col-md-3">
                                <label for="preco" class="form-control-label">Preço</label>
                                <input type="text" name="preco" id="preco" placeholder="Preço" class="form-control" >
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="form-group col-12">
                                <label for="desc_adicional" class="form-control-label">Descrição Adicional</label>
                                <div class="input-group">
                                    <textarea class="form-control" placeholder="Descrição Adicional" aria-label="With textarea"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="form-group col-md-3">
                                <label for="estoque_minimo" class="form-control-label">Estoque Mínimo</label>
                                <input type="text" name="estoque_minimo" id="estoque_minimo" placeholder="Estoque Mínimo" class="form-control" >
                            </div>
                            <div class="form-group col-md-3">
                                <label for="estoque_atual" class="form-control-label">Estoque Atual</label>
                                <input type="text" name="estoque_atual" id="estoque_atual" placeholder="Estoque Atual" class="form-control" >
                            </div>
                            <div class="form-group col-md-3">
                                <label for="unidade" class="form-control-label">Unidade</label>
                                <input type="text" name="unidade" id="unidade" placeholder="Unidade" class="form-control" >
                            </div>
                            <div class="form-group col-md-3">
                                <label for="custo" class="form-control-label">Custo</label>
                                <input type="text" name="custo" id="custo" placeholder="Custo" class="form-control" >
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="form-group col-12">
                                <label for="observacao" class="form-control-label">Observação</label>
                                <input type="text" name="observacao" id="observacao" placeholder="Observação" class="form-control">
                            </div>
                        </div>
                <?= form_close(); ?>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>