<?php

namespace app\Controllers;

use App\Controllers\BaseController;
use App\Models\ClienteModel;

class Clientes extends BaseController{

    private $clienteModel;

    public function __construct(){
        $this->clienteModel = new \App\Models\ClienteModel();
    }

    public function clientes(): string {
        return view('clientes/clientes');
    }

    public function clientes_cadastro(int $id = null) {

        $estados = ['AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas', 'BA' => 'Bahia',
            'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo', 'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso', 'MS' => 'Mato Grosso do Sul', 'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná', 'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte', 'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina', 'SP' => 'São Paulo', 'SE' => 'Sergipe', 'TO' => 'Tocantins', 'EX' => 'Exterior'
        ];

        if($id === null || $id === 0){
            return view('clientes/cliente_cadastro', ['estados' => $estados]);
        }
        
        $cliente = $this->clienteModel->find($id);
        
        if(!$cliente){
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status'   => 'error',
                    'mensagem' => 'Cliente não encontrado'
                ]);
            }

            // Se for acesso direto pela URL, mostra uma página de erro
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Cliente não encontrado");
        }
        return view('clientes/cliente_cadastro', ['cliente' => $cliente, 'estados' => $estados]);
    }
    
    //Função para Salvar o cliente no Banco de Dados
    public function salvar(){
        $clienteModel = new ClienteModel();
        $data = $this->request->getPost();
        $id = $this->request->getPost('id'); //Pega apenas o Id do formulário enviado
        $cpf = $this->request->getPost('cpf'); //Pega apenas o CPF do formulário enviado

        if(empty($id)){ //Novo cliente

            //Verifica se existe um cliente com esse CPF, mesmo excluído
            $clienteExistente = $this->clienteModel->withDeleted()->where('cpf', $cpf)->first(); 

            //Se existe...
            if ($clienteExistente) {
                if ($clienteExistente->deletado_em !== null) { //Se ele está excluído atualmente...
                    return $this->response->setJSON([ //Daremos opção de restaurar
                        'status'   => 'restore',
                        'mensagem' => 'Esse CPF já existe e está excluído. Deseja restaurar o cadastro?',
                        'id'       => $clienteExistente->id
                    ]);
                }
                //Existe um cliente ativo com esse CPF
                return $this->response->setJSON([
                    'status'   => 'error',
                    'errors' => ['cpf' => 'Já existe um cliente ativo com esse CPF.']
                ]);
            }
            $retorno = $clienteModel->insert($data);


        }else { //Atualiza cliente
            $retorno = $clienteModel->update($id, $data);
        }

        //Verifica se houve erros na validação
        if($retorno === false){
            //Retorna os erros de validação
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $clienteModel->errors()
            ]);
        }
        //Retorno com sucesso
        return $this->response->setJSON([
            'status' => 'success',
            'mensagem' => 'Cliente salvo com sucesso!'
        ]);
    }

    //Função para Listar os clientes salvos separando pela empresa a que pertencem 
    public function listar(){
        $id_empresa = 1;

        $atributos = ['id', 'id_empresa', 'cpf', 'cnpj', 'nome', 'email', 'ativo'];

        $clientes = $this->clienteModel->select($atributos)->where('id_empresa', $id_empresa)->withDeleted(false)->findAll();
        $data = [];
        foreach ($clientes as $c) {
            $data[] = [
                'id'       => $c->id,
                'nome'     => $c->nome,
                'cpf_cnpj' => $c->cpf ?: $c->cnpj, // mostra CPF ou CNPJ
                'email'    => $c->email,
                'ativo'    => $c->ativo ? 'Sim' : 'Não',
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }

    //Função para Excluir o cliente
    public function excluir(int $id = null){

        $data = [];
        if($id === null){
            $data = [
                'status' => 'error',
                'mensagem' => 'Id do cliente não informado',
            ];
        }
        //Informado o Id, então busca o cliente
        $cliente = $this->clienteModel->find($id);

        //Se não encontrar o cliente
        if (!$cliente) {
            $data = [
                'status' => 'error',
                'mensagem' => 'Cliente não encontrado',
            ];
        }

        //Tudo certo, deletar cliente
        $this->clienteModel->delete($id);
        $data = [
                'status' => 'success',
                'mensagem' => 'Cliente excluído com sucesso',
        ];

        return $this->response->setJSON($data);
    }

    //Função para restaurar um cliente excluido
    public function restaurarClienteExcluido(int $id){
        $this->clienteModel->update($id, ['deletado_em' => null]);

        $data = [
            'status'   => 'success',
            'mensagem' => 'Cliente restaurado com sucesso!'
        ];
        return $this->response->setJSON($data);
    }

    //Função para buscar os dados do cliente no pedido
    public function buscar_pedido(){
        $term = $this->request->getGet('term');

        //Se o termo digitado for menor que 2 caracteres não mostra nada
        if (!$term || strlen($term) < 2) {
            return $this->response->setJSON([]);
        }

        $model = new ClienteModel();

        $clientes = $model->groupStart()->like('nome', $term)->orLike('cpf', $term)->groupEnd()->orderBy('nome', 'ASC')->limit(10)->find();

        $result = [];

        foreach ($clientes as $cliente) {
            $result[] = [
                'label' => $cliente->nome . ' - ' . $cliente->cpf,
                'value' => $cliente->nome,
                'id'    => $cliente->id,
                'cpf'    => $cliente->cpf,
                'cnpj'    => $cliente->cnpj,
                'endereco' => $cliente->endereco,
                'numero' => $cliente->numero,
                'complemento' => $cliente->complemento,
                'cidade' => $cliente->cidade,
                'estado' => $cliente->estado,
            ];
        }

        return $this->response->setJSON($result);
    }
}
?>