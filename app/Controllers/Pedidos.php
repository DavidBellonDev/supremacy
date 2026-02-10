<?php

namespace app\Controllers;

use App\Controllers\BaseController;
use App\Models\PedidoModel;

class Pedidos extends BaseController{
    public function pedidos(): string {
        return view('pedidos/pedidos');
    }

    private $pedidoModel;
    private $itemModel;

    public function __construct(){
        $this->pedidoModel = new \App\Models\PedidoModel();
        $this->itemModel = new \App\Models\ItemModel();
    }

    public function pedidos_cadastro(int $id = null) {

        $status = ['V' => 'Vendas', 'O' => 'Orçamento'];

        if($id === null || $id === 0){
            return view('pedidos/pedidos_cadastro', ['status' => $status, 'aba_ativa' => 'principal']);
        }

        $pedido = $this->pedidoModel->find($id);
        //Formantando o numero de casas decimais de acordo com os parametros do usuario
        $total = number_format((float) $pedido->total, 2, ',', '.');
        $desconto = number_format((float) $pedido->desconto, 2, ',', '.');

        //Total dos itens
        $resultado = $this->itemModel
            ->selectSum('total', 'totalItens')
            ->where('id_pedido', $id)
            ->first();

        return view('pedidos/pedidos_cadastro', ['pedido' => $pedido, 'status' => $status, 'aba_ativa' => 'principal', 'total' => $total, 'desconto' => $desconto, 'total_itens' => $resultado?->totalItens]);
    }

    //Função para Salvar o Pedido
    public function salvar(){
        $pedidoModel = new PedidoModel();
        $data = $this->request->getPost(); //Pega os dados enviados no formulário
        $id = $this->request->getPost('id'); // Pega apenas o Id enviado no formulário
        $pedido = $this->request->getPost('pedido'); // Pega apenas o Id enviado no formulário

        //Se o id vier vazio, é pedido novo
        if(empty($id)){
            $retorno = $pedidoModel->insert($data);
        }else{
            //Atualiza o pedido
            $retorno = $pedidoModel->update($id, $data);
        }

        //Verifica se houve erros na validação
        if($retorno === false){
            //Retorna os erros de validação
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $pedidoModel->errors()
            ]);
        }
        //Retorno com sucesso
        return $this->response->setJSON([
            'status' => 'success',
            'mensagem' => 'Pedido salvo com sucesso!'
        ]);
    }

    //Função para Listar os pedidos salvos separando pela empresa a que pertencem 
    public function listar(){
        $id_empresa = 1;

        $atributos = ['id', 'pedido', 'nome_cliente', 'status', 'total', 'finalizado', 'id_empresa'];

        $pedidos = $this->pedidoModel->select($atributos)->where('id_empresa', $id_empresa)->withDeleted(false)->findAll();
        $data = [];
        foreach ($pedidos as $p) {
            $data[] = [
                'id'       => $p->id,
                'pedido'     => $p->pedido,
                'nome_cliente' => $p->nome_cliente, 
                'status'    => $p->status,
                'total'    => $p->total,
                'finalizado'    => $p->finalizado ? 'Sim' : 'Não',
                'id_empresa'    => $p->id_empresa,
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }

    //Função para Excluir o pedido
    public function excluir(int $id = null){

        $data = [];
        if($id === null){
            $data = [
                'status' => 'error',
                'mensagem' => 'Id do pedido não informado',
            ];
            return $this->response->setJSON($data);
        }
        //Informado o Id, então busca o pedido
        $pedido = $this->pedidoModel->find($id);

        //Se não encontrar o pedido
        if (!$pedido) {
            $data = [
                'status' => 'error',
                'mensagem' => 'Pedido não encontrado',
            ];
            return $this->response->setJSON($data);
        }

        if($pedido->finalizado == 1){
            $data = [
                'status' => 'error',
                'mensagem' => 'Esse pedido já está finalizado, não posso excluir',
            ];
            return $this->response->setJSON($data);
        }
        //Tudo certo, deletar pedido
        $this->pedidoModel->delete($id);
        $data = [
                'status' => 'success',
                'mensagem' => 'Pedido excluído com sucesso',
        ];
        return $this->response->setJSON($data);
    }
}
?>