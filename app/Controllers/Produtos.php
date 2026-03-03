<?php

namespace app\Controllers;
use App\Controllers\BaseController;
use App\Exceptions\ValidationException;
use App\Models\ProdutoModel;
use App\Services\ProdutoService;

class Produtos extends BaseController{

    private $produtoModel;

    public function __construct(){
        $this->produtoModel = new \App\Models\ProdutoModel();
    }

    public function produtos(): string {
        return view('produtos/produtos');
    }

    //Abrir o cadastro de produtos
    public function produtos_cadastro(int $id = null){

        $unidades = ['UN' => 'Unidade (UN)', 'KG' => 'Quilograma (KG)', 'MT' => 'Metro (MT)', 'LT' => 'Litros (LT)', 'M2' => 'Metro Quadrado (M2)', 'M3' => 'Metro Cúbico (M3)', 'PR' => 'Par (PR)', 'KW' => 'Quilowatt hora (KW)'];

        //Se não tiver id, então é um cadastro novo
        if($id === null || $id === 0){
            return view('produtos/produtos_cadastro', ['unidades' => $unidades]);
        }

        try{
            //Validar id
            $service = new ProdutoService();
            $produto = $service->produtos_cadastro($id, session()->get('id_empresa'));

            //Formantando o numero de casas decimais de acordo com os parametros do usuario
            $precoVenda = $produto->preco;
            $precoCusto = $produto->custo;
            $estoqueAtual = $produto->estoque_atual;
            $estoqueMinimo = $produto->estoque_minimo;

            return view('produtos/produtos_cadastro', ['produto' => $produto, 'unidades' => $unidades, 'preco' => $precoVenda, 'custo' => $precoCusto, 'estoque_atual' => $estoqueAtual,  'estoque_minimo' => $estoqueMinimo]);

        }catch(\DomainException $e){
            //Envia para página padrão 'Não encontrada'
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }catch(\Throwable $e){
            log_message('error', json_encode(['acao' => 'Produto Cadastro', 'produto_id' => $id, 'empresa_id' => session()->get('id_empresa'), 'erro' => $e->getMessage(),]));

            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'mensagem' => 'Erro interno'
            ]);
        }
    }

    //Função para salvar o Produto no Banco de Dados
    public function salvar(){
        $data = $this->request->getPost(); //Pega os dados enviados no formulário
       
        try{
            $service = new ProdutoService();
            $retorno = $service->salvar($data, session()->get('id_empresa'));

            if(is_array($retorno) && $retorno['status'] === 'restore'){
                return $this->response->setStatusCode(200)->setJSON([ //StatusCode 200 porque não há erro
                    'status'   => 'restore',
                    'mensagem' => 'Esse produto já existe e está excluído. Deseja restaurar o cadastro?',
                    'id'       => $retorno['id']
                ]);
            }
            return $this->response->setStatusCode(200)->setJSON([
                'status' => 'success',
                'mensagem' => 'Produto salvo com sucesso!'
            ]);
        }catch (ValidationException $e) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'validation_error',
                'errors' => $e->getErrors()
            ]);    
        }catch(\DomainException $e){
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'errors' => [
                    '_global' => $e->getMessage()
                ]
            ]);
        }catch(\Throwable $e){
            log_message('error', json_encode(['acao' => 'Salvar Produto', 'produto_id' => $this->request->getPost('id'), 'empresa_id' => session()->get('id_empresa'), 'erro' => $e->getMessage(),]));

            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'mensagem' => 'Erro interno'
            ]);
        }
    }

    //Listar os produtos cadastrados
    public function listar(){
        $id_empresa = session()->get('id_empresa'); //Pega o id da empresa na sessão

        $atributos = ['id', 'id_empresa', 'codigo', 'descricao', 'preco', 'unidade','estoque_atual', 'ativo'];

        $produtos = $this->produtoModel->select($atributos)->where('id_empresa', $id_empresa)->withDeleted(false)->findAll();
        $data = [];
        foreach ($produtos as $c) {
            $data[] = [
                'id' => $c->id,
                'codigo' => $c->codigo,
                'descricao' => $c->descricao,
                'preco' => $c->preco,
                'unidade' => $c->unidade,
                'estoque_atual' => $c->estoque_atual,
                'ativo' => $c->ativo ? 'Sim' : 'Não',
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }

    //Função para Excluir o produto
    public function excluir(int $id = null){
        try{
            $service = new ProdutoService();
            $service->excluir($id, session()->get('id_empresa')); //Chamar o método excluir do service
            return $this->response->setJSON([
                'status' => 'success',
                'mensagem' => 'Produto excluído com sucesso!'
            ]);
        }catch(\DomainException $e){ //Erro esperado
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'errors' => [
                    '_global' => $e->getMessage()
                ]
            ]);
        }catch(\Throwable $e){ //Erro inesperado
            log_message('error', json_encode(['acao' => 'Excluir Produto', 'produto_id' => $id, 'empresa_id' => session()->get('id_empresa'), 'erro' => $e->getMessage(),]));

            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'mensagem' => 'Erro interno'
            ]);
        }
    }

    //Função para restaurar um produto excluido
    public function restaurarProdutoExcluido(int $id){
        $this->produtoModel->update($id, ['deletado_em' => null]);

        $data = [
            'status'   => 'success',
            'mensagem' => 'Produto restaurado com sucesso!'
        ];
        return $this->response->setJSON($data);
    }
}
?>