<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="img/pdf.svg">
    <title>Pedido <?= $pedido->pedido ?></title>
</head>
<style>
    body{
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        color: #333;
    }

    .cabecalho{
        margin-bottom: 20px;
    }

    .titulo{
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .info{
        margin-bottom: 3px;
    }

    table{
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    thead{
        border-bottom: 2px solid #444;
    }

    th{
        text-align: left;
        padding: 6px 4px;
        font-weight: bold;
        font-size: 12px;
    }

    td{
        padding: 6px 4px;
        font-size: 12px;
    }

    tbody tr{
        border-bottom: 1px solid #ddd;
    }

    .text-right{
        text-align: right;
    }

    .total{
        margin-top: 20px;
        text-align: right;
        font-size: 14px;
        font-weight: bold;
    }
</style>

<div class="cabecalho">
    <div class="titulo">Pedido Nº <?= $pedido->pedido ?></div>

    <div class="info">
        <strong>Data do Pedido:</strong>
        <?= date('d/m/Y', strtotime($pedido->criado_em)) ?>
    </div>
    <div class="info">
        <strong>Tipo de Pedido:</strong>
        <?php if($pedido->status == 'V'): ?>
            <?= 'Venda' ?>
        <?php else: ?>
            <?= 'Orçamento' ?>
        <?php endif; ?>
    </div>
    <div class="info">
        <strong>Cliente:</strong>
        <?= $pedido->nome_cliente ?>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>Produto</th>
            <th class="text-right">Valor</th>
            <th class="text-right">Quantidade</th>
            <th class="text-right">Total</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($itens as $item): ?>
        <tr>
            <td><?= $item->descricao_produto ?></td>
            <td class="text-right">
                R$ <?= number_format($item->valor,2,',','.') ?>
            </td>
            <td class="text-right">
                <?= number_format($item->quantidade,2,',','.') ?>
            </td>
            <td class="text-right">
                R$ <?= number_format($item->total,2,',','.') ?>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<div class="total">
    Total do Pedido:
    R$ <?= number_format($pedido->total ?? 0,2,',','.') ?>
</div>