<?php 

namespace App\Services;
use App\Models\PedidoModel;
use App\Models\ClienteModel;
use App\Models\ItemModel;
use DomainException;
use App\Exceptions\ValidationException;
use App\Models\EmpresaModel;

class PedidoService{

    private PedidoModel $pedidoModel;
    private itemModel $itemModel;
    private ClienteModel $clienteModel;

    public function __construct(){
        $this->pedidoModel = new PedidoModel();
        $this->itemModel = new ItemModel();
        $this->clienteModel = new ClienteModel();
    }

    //Função para abrir o cadastro de pedido
    public function pedidos_cadastro($idPedido, $idEmpresa){

        //Verificar se o cadastro pertence a empresa do usuário
        $pedido = $this->pedidoModel->where('id_empresa', $idEmpresa)->find($idPedido);

        //Se não pertencer a empresa
        if(!$pedido){
            throw new DomainException('Pedido não encontrado');
        }

        //Total dos itens
        $totalItens = $this->itemModel->selectSum('total', 'totalItens')->where('id_pedido', $idPedido)->first();

        $valorTotalItens = $totalItens->totalItens ?? 0;

        $data = [
            'pedido' => $pedido,
            'totalItens' => $valorTotalItens,
        ];

        return $data;
    }

    //Função para salvar pedido
    public function salvar(array $data, int $idEmpresa){

        //Verificar se o id_empresa do $data é o mesmo da sessão
        if($data['id_empresa'] != $idEmpresa){
            throw new DomainException('Não posso prosseguir com o cadastro por inconsistência nos dados');
        }

        //Verificar se já está finalizado
        if($data['finalizado'] == 1){
            throw new DomainException('Esse pedido já está finalizado');
        }

        //Verificar se há um cliente no pedido se o cliente pertence a empresa do usuario logado
        $idCliente = (int) ($data['id_cliente'] ?? 0);
        $clienteExistente = $this->clienteModel->withDeleted(false)->where('id', $idCliente)->where('id_empresa', $idEmpresa)->first(); 
        if(!$clienteExistente){
            throw new DomainException('Não posso prosseguir sem um cliente válido');
        }

        //Verifica se os dados do cliente vindos do front são diferentes dos dados do banco
        if($data['id_cliente'] != $clienteExistente->id || $data['nome_cliente'] != $clienteExistente->nome || $data['cpf_cliente'] != $clienteExistente->cpf || $data['cnpj_cliente'] != $clienteExistente->cnpj || $data['endereco_cliente'] != $clienteExistente->endereco || $data['numero_cliente'] != $clienteExistente->numero || $data['complemento_cliente'] != $clienteExistente->complemento || $data['cidade_cliente'] != $clienteExistente->cidade || $data['estado_cliente'] != $clienteExistente->estado){
            throw new DomainException('Não posso prosseguir com o cadastro por inconsistência nos dados do cliente');
        }

        //Se o id for vazio, é um novo cadastro
        if(empty($data['id'])){
            $acao = 'criar';
            $db = \Config\Database::connect();
            $db->transStart();

            $empresaModel = new EmpresaModel();
            $empresaModel->where('id', $idEmpresa)->set('num_pedido', 'num_pedido + 1', false)->update();

            $empresa = $empresaModel->find($idEmpresa);
            $data['pedido'] = $empresa->num_pedido;

            $retorno = $this->pedidoModel->insert($data);
            $idNovoPedido = $this->pedidoModel->insertID();
            $numeroPedido = $data['pedido'];

            $db->transComplete();
            
        }else{ //Senão, atualizar
            $acao = 'atualizar';
            $idNovoPedido = $data['id'];
            $numeroPedido = $data['pedido'];
            $retorno = $this->pedidoModel->update($data['id'], $data);
        }

        //Verifica se houve erros na validação
        if($retorno === false){
            //Retorna os erros de validação
            throw new ValidationException($this->pedidoModel->errors());
        }
        //Retorno com sucesso
        return [ 'acao' => $acao,
            'idNovoPedido' => $idNovoPedido,
            'numeroPedido' => $numeroPedido,
        ];
    }

    //Função para excluir o pedido
    public function excluir(int $idPedido, int $idEmpresa){

        //Informado o Id, então busca o pedido
        $pedido = $this->pedidoModel->where('id', $idPedido)->where('id_empresa', $idEmpresa)->first(); 

        //Se não encontrar o pedido ou Verificar se esse $id pertence a empresa do usuario logado
        if(!$pedido || $pedido->id_empresa != $idEmpresa){
            throw new DomainException('Pedido não encontrado');
        }

        if($pedido->finalizado == 1){
            throw new DomainException('Esse pedido já está finalizado, não posso excluir');
        }

        //Tudo certo, deletar pedido
        $this->pedidoModel->delete($idPedido);
    }

    //Função para finalizar o pedido
    public function finalizar(int $id, int $idEmpresa){

        $pedido = $this->pedidoModel->where('id', $id)->where('id_empresa', $idEmpresa)->first();

        if(!$pedido){
            throw new DomainException('Não encontrei o pedido selecionado');
        }

        if($pedido->finalizado == 1){
            throw new DomainException('Esse pedido já está finalizado');
        }

        $retorno = $this->pedidoModel->update($id, ['finalizado' => 1]);
        
        if($retorno === false){
            //Retorna os erros de validação
            throw new ValidationException($this->pedidoModel->errors());
        }

    }
}

?>