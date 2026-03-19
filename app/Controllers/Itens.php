<?php 

namespace app\Controllers;
use App\Controllers\BaseController;
use App\Models\ProdutoModel;
use App\Services\ItemService;
use App\Exceptions\ValidationException;
use DomainException;
use Throwable;

class Itens extends BaseController{

    private $itemModel;

    public function __construct(){
        $this->itemModel = new \App\Models\ItemModel();
    }

    //Função para Salvar o Item  no pedido
    public function salvar(){
        
        $data = $this->request->getPost(); //Pega os dados enviados no formulário
        try{
            $service = new ItemService();
            $retorno = $service->salvar($data, session()->get('id_empresa'));
            return $this->response->setStatusCode(200)->setJSON([
                'status' => 'success',
                'mensagem' => 'Item salvo com sucesso!',
                'totalItens' => $retorno['totalItens']
            ]);
        }catch(ValidationException $e){
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'validation_error',
                'errors' => $e->getErrors()
            ]);
        }catch(DomainException $e){
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'errors' => [
                    '_global' => $e->getMessage()
                ]
            ]);
        }catch(Throwable $e){
            log_message('error', json_encode(['acao' => 'Salvar Pedido', 'pedido_id' => $this->request->getPost('id'), 'empresa_id' => session()->get('id_empresa'), 'erro' => $e->getMessage(),]));

            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'mensagem' => 'Erro interno'
            ]);
        }
    }

    //Função para Excluir o item
    public function excluir(int $id = null, int $idPedido = null){

        try{
            $service = new ItemService();
            $retorno = $service->excluir($id, $idPedido, session()->get('id_empresa'));
            return $this->response->setJSON([
                'status' => 'success',
                'mensagem' => 'Item excluído com sucesso!',
                'totalItens' => $retorno['totalItens']
            ]);

        }catch(\DomainException $e){
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'errors' => [
                    '_global' => $e->getMessage()
                ]
            ]);
        }catch(\Throwable $e){
            log_message('error', json_encode(['acao' => 'Excluir Item', 'item_id' => $id, 'empresa_id' => session()->get('id_empresa'), 'erro' => $e->getMessage(),]));
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'mensagem' => 'Erro interno'
            ]);
        }
    }

    //Função para Listar os itens salvos separando pela empresa a que pertencem 
    public function listar(){

        $id_pedido = $this->request->getGet('id');
        $atributos = ['id', 'descricao_produto', 'valor', 'quantidade', 'desconto', 'total', 'id_pedido', 'id_empresa', 'observacao'];

        $itens = $this->itemModel->select($atributos)->where('id_pedido', $id_pedido)->withDeleted(false)->findAll();
        $data = [];
        foreach ($itens as $i) {
            $data[] = [
                'id' => $i->id,
                'descricao_produto' => $i->descricao_produto,
                'valor_modal'    => $i->valor,
                'valor_tabela'   => $i->valor,
                'quantidade_modal' => $i->quantidade,
                'quantidade_tabela' => $i->quantidade,
                'desconto_modal' => $i->desconto,
                'desconto_tabela'=> $i->desconto,
                'total_modal'    => $i->total,
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