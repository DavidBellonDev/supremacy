<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/menu_conteudo.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/datatable.css') ?>">
    <link rel="icon" type="image/svg+xml" href="img/icon.svg">
    <title>Clientes</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- DataTables Bootstrap 5 CSS -->
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
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
                        <h3>Clientes</h3>
                    </div>
                    <div class="col-3">
                        <button id="novoCliente" class="form-control btn btn-danger">Novo Cliente</button>
                    </div>
                </div>
                <table id="listaClientes" class="col-md-6 col-sm-4 table text-light">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF/CNPJ</th>
                            <th>Email</th>
                            <th>Ativo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>  
                    </tbody>
                </table>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (obrigatório para DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
        $(document).ready(function () {
            $('#listaClientes').DataTable({
                "ajax": "<?= site_url('clientes/listar') ?>", // rota que retorna JSON
                "responsive": false,
                "columns": [
                    { "data": 'nome' },
                    { data: 'cpf_cnpj',
                        render: function (data, type) { // Aplicar Mascara no CPF/CNPJ
                            if (type !== 'display') return data;
                            data = data.replace(/\D/g, '');
                            return data.length === 11
                                ? data.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4')
                                : data.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
                        }
                    },
                    { "data": 'email' },
                    { data: 'ativo',
                        render: function(data, type, row){
                            var ativo = data === 'Sim' || data == 1 || data === true;
                        
                            return ativo
                                ? '<i class="bi bi-check-circle-fill text-success fs-5" data-export="Sim" title="Ativo"></i>'
                                : '<i class="bi bi-x-circle-fill text-danger fs-5" data-export="Não" title="Inativo"></i>';
                        }
                    },
                    {data: 'id',
                        render: function (data, type, row) {
                            return `
                                <button class="btn btn-sm btn-warning me-2 editar" data-id="${data}">
                                    <i class="bi bi-pencil-fill"></i> Editar
                                </button>
                                <button class="btn btn-sm btn-danger excluir" data-id="${data}" data-nome="${row.nome}">
                                    <i class="bi bi-trash-fill"></i> Excluir
                                </button>
                            `;
                        }
                    }
                ],
                columnDefs: [
                    { className: "text-center", targets: "_all" }, // centraliza todas as colunas
                    { targets: 0, // coluna "Nome"
                      render: $.fn.dataTable.render.ellipsis(25) // Limite de 25 caract. na listagem
                    }
                ],
                order: [[0, 'desc']],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json'
                },
                info: false,
                dom: "<'row'<'col-md-6'l><'col-md-6'f>>" +
                    "<'row'<'col-12'tr>>" +
                    "<'row'<'col-md-5'B><'col-md-7'p>>",
                buttons: [
                    { extend: 'excel', text: 'Excel', exportOptions: {
                        columns: ':not(:last-child)',  // exclui a última coluna (Ações)
                        format: { //Incluir informação do 'Ativo' na lista de 'Excel'
                            body: function (data, row, column, node) {
                                const icon = $('i', node);
                                if (icon.length) {
                                    return icon.data('export');
                                }
                                return data;
                            }
                        } 
                    }},
                    { extend: 'pdf', text: 'PDF', exportOptions: {
                        columns: ':not(:last-child)', // exclui a última coluna (Ações)
                        format: { //Incluir informação do 'Ativo' na lista de 'PDF'
                            body: function (data, row, column, node) {
                                const icon = $('i', node);
                                if (icon.length) {
                                    return icon.data('export');
                                }
                                return data;
                            }
                        } 
                    }},
                    { extend: 'print', text: 'Imprimir', exportOptions: {
                        columns: ':not(:last-child)', // exclui a última coluna (Ações)
                        format: { //Incluir informação do 'Ativo' na lista de 'Imprimir'
                            body: function (data, row, column, node) {
                                const icon = $('i', node);
                                if (icon.length) {
                                    return icon.data('export');
                                }
                                return data;
                            }
                        } 
                    }}
                ]  
            });
        });
    </script>
    <script src="https://cdn.datatables.net/plug-ins/1.13.7/dataRender/ellipsis.js"></script>
    <script src="<?= base_url('js/clientes.js') ?>"></script> <!-- Js de Clientes -->

</body>
</html>