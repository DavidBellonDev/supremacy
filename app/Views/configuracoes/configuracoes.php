<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/menu_conteudo.css') ?>">
    <link rel="icon" type="image/svg+xml" href="img/icon.svg">
    <title>Configurações</title>
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
                        <h3>Configurações</h3>
                    </div>
                    <div class="col-3">
                         <button id="btnEditarEmpresa" class="form-control btn btn-danger" data-mode="editar">Editar Empresa</button>
                    </div>
                </div>
                <?= form_open('configuracoes/atualizar_empresa', ['id' => 'editarEmpresa']) ?>
                    <?= csrf_field() ?>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nome" class="form-control-label">Nome</label>
                                <input type="text" name="nome" id="nome" placeholder="Nome" class="form-control dados-empresa" 
                                value="<?= $empresa->nome ?? '' ?>" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="cpf" class="form-control-label">CPF</label>
                                <input type="text" name="cpf" id="cpf" placeholder="CPF" class="form-control dados-empresa" 
                                value="<?= $empresa->cpf ?? '' ?>" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="cnpj" class="form-control-label">CNPJ</label>
                                <input type="text" name="cnpj" id="cnpj" placeholder="CNPJ" class="form-control dados-empresa" value="<?= $empresa->cnpj ?? '' ?>" readonly>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="form-group col-md-4">
                                <label for="endereco" class="form-control-label">Endereço</label>
                                <input type="text" name="endereco" id="endereco" placeholder="Endereço" class="form-control dados-empresa" value="<?= $empresa->endereco ?? '' ?>" readonly>
                            </div>
                            <div class="form-group col-md-1">
                                <label for="numero" class="form-control-label">Número</label>
                                <input type="text" name="numero" id="numero" placeholder="N°" class="form-control dados-empresa" value="<?= $empresa->numero ?? '' ?>" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="complemento" class="form-control-label">Complemento</label>
                                <input type="text" name="complemento" id="complemento" placeholder="Complemento" class="form-control dados-empresa" value="<?= $empresa->complemento ?? '' ?>" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="cidade" class="form-control-label">Cidade</label>
                                <input type="text" name="cidade" id="cidade" placeholder="Cidade" class="form-control dados-empresa" value="<?= $empresa->cidade ?? '' ?>" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="estado" class="form-control-label">Estado</label>
                                <select disabled name="estado" id="estado" class="form-select campo-select">
                                    <option value=""></option>
                                    <?php foreach ($estados as $sigla => $estado): ?>
                                        <option value="<?= $sigla ?>" <?= ($empresa->estado ?? '') === $sigla ? 'selected' : '' ?>><?= $estado ?></option>
                                    <?php endforeach; ?>    
                                </select>
                                <input type="hidden" name="estado" id="estado_hidden">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="form-group col-md-3">
                                <label for="cep" class="form-control-label">CEP</label>
                                <input type="text" name="cep" id="cep" placeholder="CEP" class="form-control dados-empresa" value="<?= $empresa->cep ?? '' ?>" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="telefone" class="form-control-label">Telefone</label>
                                <input type="text" name="telefone" id="telefone" placeholder="Telefone" class="form-control dados-empresa" value="<?= $empresa->telefone ?? '' ?>" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="celular" class="form-control-label">Celular</label>
                                <input type="text" name="celular" id="celular" placeholder="Celular" class="form-control dados-empresa" value="<?= $empresa->celular ?? '' ?>" readonly>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="email" class="form-control-label">E-mail</label>
                                <input type="text" name="email" id="email" placeholder="Email" class="form-control dados-empresa" value="<?= $empresa->email ?? '' ?>" readonly>
                            </div>
                        </div>
                <?= form_close(); ?>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Mascaras -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url('js/configuracoes.js') ?>"></script> <!-- Js de Configurações -->

</body>
</html>