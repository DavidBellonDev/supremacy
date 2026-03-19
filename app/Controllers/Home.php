<?php

namespace app\Controllers;
use App\Controllers\BaseController;
use App\Models\ItemModel;
use App\Models\PedidoModel;
use App\Models\ProdutoModel;

class Home extends BaseController{
    public function home(){

        # *** Gerar o gráfico de pedidos finalizados ***
        $pedidoModel = new PedidoModel();
        $itemModel = new ItemModel();
        $produtoModel = new ProdutoModel();
        $id_empresa = session()->get('id_empresa');;

        $dataInicio = date('Y-m-01', strtotime('-5 months')); // Contar a partir do primeiro dia dos ultimos 6 meses

        $result = $pedidoModel
            ->select("
                DATE_FORMAT(criado_em,'%Y-%m') as mes,
                SUM(CASE WHEN finalizado = 1 THEN total ELSE 0 END) as finalizados,
                SUM(CASE WHEN finalizado = 0 THEN total ELSE 0 END) as abertos
            ")
            ->where('criado_em >=', $dataInicio) 
            ->where('id_empresa', $id_empresa)
            ->groupBy("mes")
            ->orderBy("mes","ASC")
            ->findAll();

        $nomesMeses = [1=>'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];

        $meses = [];
        $finalizados = [];
        $abertos = [];

        // Criar os últimos 6 meses
        for($i=5;$i>=0;$i--){ // Buscando dos ultimos 6 meses

            $dataMes = strtotime("-$i months");

            $mesNumero = date('n',$dataMes);
            $ano = date('Y',$dataMes);

            $chave = date('Y-m',$dataMes);

            $meses[$chave] = $nomesMeses[$mesNumero].'/'.$ano;
            $finalizados[$chave] = 0;
            $abertos[$chave] = 0;

        }

        // Substituir meses que possuem venda
        foreach($result as $r){
            if(isset($meses[$r->mes])){
                $finalizados[$r->mes] = (float)$r->finalizados;
                $abertos[$r->mes] = (float)$r->abertos;
            }
        }

        $data['meses'] = array_values($meses);
        $data['finalizados'] = array_values($finalizados);
        $data['abertos'] = array_values($abertos);

        $totalFinalizados = $pedidoModel
        ->selectSum('total')
        ->where('id_empresa', $id_empresa)
        ->where('finalizado',1)
        ->first();

        $data['totalFinalizados'] = $totalFinalizados->total ?? 0;

        # *** Gerar a lista de clientes que mais compram ***
        $topClientes = $pedidoModel
        ->select('clientes.nome, SUM(pedidos.total) as total_compras')
        ->join('clientes', 'clientes.id = pedidos.id_cliente')
        ->where('pedidos.finalizado', 1)
        ->where('pedidos.id_empresa', $id_empresa)
        ->groupBy('clientes.id')
        ->orderBy('SUM(pedidos.total)', 'DESC')
        ->limit(4)
        ->findAll();

        $data['topClientes'] = $topClientes;

        # *** Gerar lista dos produtos mais vendidos ***
        $topProdutos = $itemModel
        ->select('produtos.descricao, SUM(itens.total) as total_produtos')
        ->join('produtos', 'produtos.id = itens.id_produto')
        ->where('itens.id_empresa', $id_empresa)
        ->groupBy('produtos.id')
        ->orderBy('SUM(itens.total)', 'DESC')
        ->limit(4)
        ->findAll();

        $data['topProdutos'] = $topProdutos;

        # *** Alertas - Orçamento a mais de 7 dias **
        $orcamentosAbertosTotal = $pedidoModel->where('status', 'O')->where('id_empresa', $id_empresa)->countAllResults();
        $data['orcamentosAbertosTotal'] = $orcamentosAbertosTotal;

        # *** Alertas - Pedidos não finalizados ***
        $pedidosAtrasados = $pedidoModel->where('status', 'V')->where('finalizado', '0')->where('id_empresa', $id_empresa)->countAllResults();
        $data['pedidosAtrasadosValor'] = $pedidosAtrasados;

        //Total de Pedidos
        $totalDePedidos = $pedidoModel->where('id_empresa', $id_empresa)->countAllResults();
        $data['totalDePedidos'] = $totalDePedidos;

        //Total de Pedidos Finalizados
        $totalDePedidosFinalizados = $pedidoModel->where('id_empresa', $id_empresa)->where('finalizado', 1)->countAllResults();
        $data['totalDePedidos'] = $totalDePedidos;
        $data['totalDePedidosFinalizados'] = $totalDePedidosFinalizados;

        return view('home/home',$data);
    }
}
?>