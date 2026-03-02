<?php 

namespace App\Services;
use App\Models\ClienteModel;
use DomainException;
use DOMAttr;
use App\Exceptions\ValidationException;

class ClienteService{

    private ClienteModel $clienteModel;
    
    public function __construct(){
       $this->clienteModel = new ClienteModel();
    }

    //Função para abrir o cadastro de clientes
    public function clientes_cadastro(int $id, int $id_empresa){

        //Verificar se o cadastro pertence a empresa do usuário logado
        $cliente = $this->clienteModel->where('id_empresa', $id_empresa)->find($id);

        //Se não pertencer, dar mensagem de erro
        if(!$cliente){
            throw new DomainException('Cliente não encontrado');
        }

        return $cliente;
    }

    //Função para salvar o cliente no banco de dados ou atualizar
    public function salvar(array $data, int $idEmpresaSession){

        //Compara os id_empresa recebidos 
        if($data['id_empresa']!= $idEmpresaSession){
            throw new DomainException('Não posso prosseguir com o cadastro por inconsistência nos dados');
        }

        //Verifica se CPF ou CNPJ foram informados
        if((empty($data['cpf']) && empty($data['cnpj'])) || ($data['cpf'] == null && $data['cnpj'] == null)){
           throw new ValidationException([
                'cpf' => 'Informe o CPF ou CNPJ',
                'cnpj' => 'Informe o CPF ou CNPJ'
            ]); 
        }

        if(empty($data['cnpj'])){ //Se os dados de CNPJ forem vazios/null
            //Busca por CPF
            $clienteExistente = $this->clienteModel->withDeleted()->where('cpf', $data['cpf'])->where('id_empresa', $idEmpresaSession)->first(); 
        }else{ //Se os dados de CPF forem vazios/null
            //Busca por CNPJ
            $clienteExistente = $this->clienteModel->withDeleted()->where('cnpj', $data['cnpj'])->where('id_empresa', $idEmpresaSession)->first(); 
        }

        //Se existe...
        if ($clienteExistente) {
            if ($clienteExistente->deletado_em !== null) { //Se ele está excluído atualmente...
                return [ //Daremos opção de restaurar
                    'status'   => 'restore',
                    'id'       => $clienteExistente->id
                ];
            }
        }

        if(empty($data['id'])){ //Novo cliente
            //Salvar o Novo Cliente
            $retorno = $this->clienteModel->insert($data);
        }else { //Atualiza cliente
            $retorno = $this->clienteModel->update($data['id'], $data);
        }

        //Verifica se houve erros na validação
        if($retorno === false){
            //Retorna os erros de validação
            throw new ValidationException($this->clienteModel->errors());
        }
        //Retorno com sucesso
        return true;
    }

    //Função para excluir um cliente ou não
    public function excluir(int $idCliente, int $idEmpresa){

        //Informado o Id, então busca o cliente
        $cliente = $this->clienteModel->where('id', $idCliente)->where('id_empresa', $idEmpresa)->first(); 

        //Se não encontrar o cliente ou Verificar se esse $id pertence a empresa do usuario logado
        if(!$cliente || $cliente->id_empresa != $idEmpresa){
            throw new DomainException('Cliente não encontrado');
        }

        //Tudo certo, deletar cliente
        $this->clienteModel->delete($idCliente);
    }

    //Função para restaurar ou não cliente antes excluído
    public function restaurar_cliente(int $idCliente, int $id_empresa){

        $cliente = $this->clienteModel->withDeleted()->where('id', $idCliente)->where('id_empresa', $id_empresa)->first(); 

        if(!$cliente){
            throw new \DomainException('Cliente não encontrado');
        }

        if($cliente->id_empresa != $id_empresa){
            throw new \DomainException('Cliente não encontrado');
        }

        $this->clienteModel->update($idCliente, ['deletado_em' => null]);
    }
}
?>


