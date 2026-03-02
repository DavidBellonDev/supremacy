<?php

namespace app\Controllers;
use App\Controllers\BaseController;
use App\Models\ClienteModel;
use App\Services\ClienteService;
use App\Exceptions\ValidationException;
use DomainException;

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

        //Se não vier id, é cadastro de cliente novo
        if($id === null || $id === 0){
            return view('clientes/cliente_cadastro', ['estados' => $estados]);
        }

        try{
            //Validar id
            $service = new ClienteService();
            $cliente = $service->clientes_cadastro($id, session()->get('id_empresa'));
            
            return view('clientes/cliente_cadastro', ['cliente' => $cliente, 'estados' => $estados]);
        }catch(\DomainException $e){
            //Envia para página padrão 'Não encontrada'
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }catch (\Throwable $e) { //Erro inesperado...
            log_message('error', json_encode(['acao' => 'Clientes Cadastro', 'cliente_id' => $id, 'empresa_id' => session()->get('id_empresa'), 'erro' => $e->getMessage(),]));

            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'mensagem' => 'Erro interno'
            ]);
        }
    }
    
    //Função para Salvar o cliente no Banco de Dados
    public function salvar(){
        $data = $this->request->getPost();
        try{
            $service = new ClienteService();
            $retorno = $service->salvar($data, session()->get('id_empresa'));

            if(is_array($retorno) && $retorno['status'] === 'restore'){
                return $this->response->setStatusCode(200)->setJSON([ //StatusCode 200 porque não há erro
                    'status'   => 'restore',
                    'mensagem' => 'Esse cliente já existe e está excluído. Deseja restaurar o cadastro?',
                    'id'       => $retorno['id']
                ]);
            }
            return $this->response->setStatusCode(200)->setJSON([
                'status' => 'success',
                'mensagem' => 'Cliente salvo com sucesso!'
            ]);
        }catch (ValidationException $e) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'validation_error',
                'errors' => $e->getErrors()
            ]);
        }catch(DomainException $e){ //Erro esperado
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'errors' => [
                    '_global' => $e->getMessage()
                ]
            ]);
        }catch (\Throwable $e) { //Erro inesperado...
            log_message('error', json_encode(['acao' => 'Salvar Cliente', 'cliente_id' => $this->request->getPost('id'), 'empresa_id' => session()->get('id_empresa'), 'erro' => $e->getMessage(),]));

            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'mensagem' => 'Erro interno'
            ]);
        }
    }

    //Função para Listar os clientes salvos separando pela empresa a que pertencem 
    public function listar(){
        $id_empresa = session()->get('id_empresa'); //Pega o id_empresa da session

        $atributos = ['id', 'id_empresa', 'cpf', 'cnpj', 'nome', 'email', 'ativo']; //Dados enviados

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
        try{
            $service = new ClienteService();
            $service->excluir($id, session()->get('id_empresa')); //Chamar método excluir do Service
            return $this->response->setJSON([
                'status' => 'success',
                'mensagem' => 'Cliente excluído com sucesso!'
            ]);
        }catch(\DomainException $e){ //Erro esperado...
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'errors' => [
                    '_global' => $e->getMessage()
                ]
            ]);
        }catch (\Throwable $e) { //Erro inesperado...
            log_message('error', json_encode(['acao' => 'Excluir Cliente', 'cliente_id' => $id, 'empresa_id' => session()->get('id_empresa'), 'erro' => $e->getMessage(),]));

            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'mensagem' => 'Erro interno'
            ]);
        }
    }

    //Função para restaurar um cliente excluido (Usando Service)
    public function restaurarClienteExcluido(int $id){
        try{
            $service = new ClienteService();
            $service->restaurar_cliente($id, session()->get('id_empresa'));
            return $this->response->setJSON([
                'status' => 'success',
                'mensagem' => 'Cliente restaurado com sucesso'
            ]);
        }catch(\DomainException $e){
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'mensagem' => $e->getMessage()
            ]);
        }
    }

    //Função para buscar os dados do cliente no pedido
    public function buscar_pedido(){
        $term = $this->request->getGet('term');
        $id_empresa = session()->get('id_empresa');

        //Se o termo digitado for menor que 2 caracteres não mostra nada
        if (!$term || strlen($term) < 2) {
            return $this->response->setJSON([]);
        }

        $model = new ClienteModel(); //Carregar Model de Cliente

        $clientes = $model->where('id_empresa', $id_empresa)->withDeleted(false)->groupStart()->like('nome', $term)->orLike('cpf', $term)->groupEnd()->orderBy('nome', 'ASC')->limit(10)->findAll();

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