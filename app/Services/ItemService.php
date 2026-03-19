<?php 

namespace App\Services;

use App\Entities\Pedido;
use App\Models\ItemModel;
use App\Models\PedidoModel;
use DomainException;
use App\Exceptions\ValidationException;

class ItemService{

    private ItemModel $itemModel;
    private PedidoModel $pedidoModel;

    public function __construct(){
        $this->itemModel = new ItemModel();
        $this->pedidoModel = new PedidoModel();
    }

    //Função para salvar o item do pedido
    public function salvar(array $data, int $idEmpresa){

        //Verificar se o id_empresa do $data é o mesmo da sessão
        if($data['id_empresa'] != $idEmpresa){
            throw new DomainException('Não posso prosseguir com o cadastro por inconsistência nos dados');
        }

        //Se o id vier vazio, é item novo
        if(empty($data['id'])){
            $retorno = $this->itemModel->insert($data);
        }else{
            //Atualiza o pedido
            $retorno = $this->itemModel->update($data['id'], $data);
        }

        //Verifica se houve erros na validação
        if($retorno === false){
            //Retorna os erros de validação
            throw new ValidationException($this->itemModel->errors());
        }

        //Retorno com sucesso
        //Recalcular o total do Pedido e atualizar
        $resultado = $this->itemModel
            ->selectSum('total', 'totalItens')
            ->where('id_pedido', $data['id_pedido'])
            ->first();

        //Atualizar o total do pedido
        $retorno = $this->pedidoModel->update($data['id_pedido'], ['total' => $resultado?->totalItens ?? 0]);
        $data = [
            'totalItens' => $resultado?->totalItens ?? 0
        ];
        return $data;
    }

    //Função para excluir um item do pedido
    public function excluir(int $idItem, int $idPedido, int $idEmpresa){

        //Informado o id, então busca ele no pedido
        $item = $this->itemModel->where('id', $idItem)->where('id_pedido', $idPedido)->first(); 

        //Se não encontrar o item ou Verificar se esse $id pertence a empresa do usuario logado
        if(!$item || $item->id_empresa != $idEmpresa){
            throw new DomainException('Item não encontrado');
        }

        //Tudo certo, deletar pedido
        $this->itemModel->delete($idItem);

        //Recalcular o total do Pedido e atualizar
        $resultado = $this->itemModel
            ->selectSum('total', 'totalItens')
            ->where('id_pedido', $item->id_pedido)
            ->first();

        //Atualizar o total do pedido
        $this->pedidoModel->update($item->id_pedido, ['total' => $resultado?->totalItens ?? 0]);

         $data = [
            'totalItens' => $resultado?->totalItens ?? 0
        ];
        return $data;
    }
}

?>