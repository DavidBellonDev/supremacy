<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- DataTables Bootstrap 5 -->
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

</head>
<body>
    <div class="row">
        <div class="col-3">
            <?= $this->include('menu/_menu'); ?> <!-- Menu -->  
        </div>
        <div class="col-9 container mt-5">
            <table id="example" class="table table-striped table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Ana Silva</td>
                        <td>ana@email.com</td>
                        <td>Ativo</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>João Souza</td>
                        <td>joao@email.com</td>
                        <td>Inativo</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Maria Costa</td>
                        <td>maria@email.com</td>
                        <td>Ativo</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery (obrigatório para DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#example').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json'
            }
        });
    });
</script>

</body>
</html>