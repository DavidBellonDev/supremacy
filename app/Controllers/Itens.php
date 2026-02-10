<?php 

namespace app\Controllers;
use App\Controllers\BaseController;
use App\Models\ItemModel;
use App\Models\ProdutoModel;

class Itens extends BaseController{

    private $itemModel;
    private $produtoModel;
    private $pedidoModel;

    public function __construct(){
        $this->itemModel = new \App\Models\ItemModel();
        $this->produtoModel = new \App\Models\ProdutoModel();
        $this->pedidoModel = new \App\Models\PedidoModel();
    }

    //Função para Salvar o Item  no pedido
    public function salvar(){
        $itemModel = new ItemModel();
        $data = $this->request->getPost(); //Pega os dados enviados no formulário
        $id = $this->request->getPost('id_item'); // Pega apenas o Id enviado no formulário
        $id_pedido = $this->request->getPost('id_pedido'); // Pega apenas o Id do pedido

        //Se o id vier vazio, é item novo
        if(empty($id)){
            $retorno = $itemModel->insert($data);
        }else{
            //Atualiza o pedido
            $retorno = $itemModel->update($id, $data);
        }

        //Verifica se houve erros na validação
        if($retorno === false){
            //Retorna os erros de validação
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $itemModel->errors()
            ]);
        }
        //Retorno com sucesso
        //Recalcular o total do Pedido e atualizar
        $resultado = $this->itemModel
            ->selectSum('total', 'totalItens')
            ->where('id_pedido', $id_pedido)
            ->first();

        //Atualizar o total do pedido
        $retorno = $this->pedidoModel->update($id_pedido, ['total' => $resultado?->totalItens ?? 0]);

        return $this->response->setJSON([
            'status'     => 'success',
            'mensagem'   => 'Item salvo com sucesso!',
            'totalItens' => $resultado?->totalItens ?? 0
        ]);
    }

    //Função para Excluir o item
    public function excluir(int $id = null){

        $data = [];
        if($id === null){
            $data = [
                'status' => 'error',
                'mensagem' => 'Id do Item não informado',
            ];
            return $this->response->setJSON($data);
        }
        //Informado o Id, então busca o item
        $item = $this->itemModel->find($id);

        //Se não encontrar o item
        if (!$item) {
            $data = [
                'status' => 'error',
                'mensagem' => 'Item não encontrado',
            ];
            return $this->response->setJSON($data);
        }

        //Tudo certo, deletar item
        $this->itemModel->delete($id);

        //Recalcular o total do Pedido e atualizar
        $resultado = $this->itemModel
            ->selectSum('total', 'totalItens')
            ->where('id_pedido', $item->id_pedido)
            ->first();

        //Atualizar o total do pedido
        $retorno = $this->pedidoModel->update($item->id_pedido, ['total' => $resultado?->totalItens ?? 0]);

        $data = [
                'status' => 'success',
                'mensagem' => 'Item excluído com sucesso',
                'totalItens' => $resultado?->totalItens ?? 0
        ];
        return $this->response->setJSON($data);
    }

    //Função para Listar os itens salvos separando pela empresa a que pertencem 
    public function listar(int $id = null){
        $id_pedido = $id;

        $atributos = ['id', 'descricao_produto', 'valor', 'quantidade', 'desconto', 'total', 'id_pedido', 'id_empresa', 'observacao'];

        $itens = $this->itemModel->select($atributos)->where('id_pedido', $id_pedido)->withDeleted(false)->findAll();
        $data = [];
        foreach ($itens as $i) {
            $data[] = [
                'id' => $i->id,
                'descricao_produto' => $i->descricao_produto,
                'valor_modal'    => number_format((float) $i->valor, 2, ',', '.'),
                'valor_tabela'   => $i->valor,
                'quantidade_modal' => number_format((float) $i->quantidade, 2, ',', '.'),
                'quantidade_tabela' => $i->quantidade,
                'desconto_modal' => number_format((float) $i->desconto, 2, ',', '.'),
                'desconto_tabela'=> $i->desconto,
                'total_modal'    => number_format((float) $i->total, 2, ',', '.'),
                'total_tabela'   => $i->total,
                'id_pedido'      => $i->id_pedido,
                'id_empresa'     => $i->id_empresa,
                'observacao'     => $i->observacao,
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }

    //Função para buscar produtos para pedido
    public function buscar_itens_pedido(){
        $term = $this->request->getGet('term');

        //Se o termo digitado for menor que 2 caracteres não mostra nada
        if (!$term || strlen($term) < 2) {
            return $this->response->setJSON([]);
        }

        $model = new ProdutoModel();

        $produtos = $model->groupStart()->like('descricao', $term)->groupEnd()->orderBy('descricao', 'ASC')->limit(10)->find();

        $result = [];

        foreach ($produtos as $produto) {
            $result[] = [
                'label' => $produto->codigo . ' - ' . $produto->descricao,
                'value' => $produto->descricao,
                'id'    => $produto->id,
                'preco' => number_format((float) $produto->preco, 2, ',', '.'),
            ];
        }
        return $this->response->setJSON($result);
    }
}    
?>