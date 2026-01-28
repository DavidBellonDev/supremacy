<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/menu_conteudo.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/datatable.css') ?>">
    <link rel="icon" type="image/svg+xml" href="img/icon.svg">
    <title>Pedidos</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- DataTables Bootstrap 5 -->
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
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
                        <h3>Pedidos</h3>
                    </div>
                    <div class="col-3">
                        <button id="novoPedido" class="form-control btn btn-danger">Novo Pedido</button>
                    </div>
                </div>
                <table id="listaPedidos" class="table text-light" >
                    <thead>
                        <tr>
                            <th>Pedido</th>
                            <th>Cliente</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Finalizado</th> 
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>   
                    </tbody>
                </table>
            </main>
        </div>
    </div>
    <!-- Bootstrap JS -->
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
            $('#listaPedidos').DataTable({
                "ajax": "<?= site_url('pedidos/listar') ?>", // rota que retorna JSON
                "responsive": false,
                "columns": [
                    { "data": 'pedido' },
                    { "data": 'nome_cliente' },
                    { data: 'status',
                        render: function(data, type, row){
                            if(row.status == 'V'){
                                return `<span class="badge bg-primary">Venda</span>`;
                            }else{
                                return `<span class="badge bg-danger">Orçamento</span>`;
                            }
                        }
                    },
                    { data: 'total',
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
                    {data: 'finalizado',
                        render: function (data, type, row) {
                            var finalizado = data === 'Sim' || data == 1 || data === true;
                            return finalizado
                            ? '<i class="bi bi-check-circle-fill text-success fs-5" title="Finalizado"></i>': '';
                        }
                    },
                    {data: 'id',
                        render: function (data, type, row) {
                            return `
                                <button class="btn btn-sm btn-warning editar" data-id="${data}">
                                    <i class="bi bi-pencil-fill"></i> Editar
                                </button>
                                <button class="btn btn-sm btn-danger excluir" data-id="${data}" data-nome="${row.nome_cliente}" data-pedido="${row.pedido}">
                                    <i class="bi bi-trash-fill"></i> Excluir
                                </button>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Mais</button>
                                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <li><a class="dropdown-item" href="#">Finalizar</a></li>
                                        <li><a class="dropdown-item" href="#">Gerar PDF</a></li>
                                    </ul>
                                </div>
                            `;
                        }
                    }
                ],
                columnDefs: [
                    { className: "text-center", targets: "_all" } // centraliza todas as colunas
                ],
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
    <script src="<?= base_url('js/pedidos.js') ?>"></script>
</body>
</html>