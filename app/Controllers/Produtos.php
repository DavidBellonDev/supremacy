<?php

namespace app\Controllers;
use App\Controllers\BaseController;
use App\Models\ProdutoModel;

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

        if($id === null || $id === 0){
            return view('produtos/produtos_cadastro', ['unidades' => $unidades]);
        }

        $produto = $this->produtoModel->find($id);
        if(!$produto){
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status'   => 'error',
                    'mensagem' => 'Produto não encontrado'
                ]);
            }

            // Se for acesso direto pela URL, mostra uma página de erro
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Produto não encontrado");
        }
        //Formantando o numero de casas decimais de acordo com os parametros do usuario
        $precoVenda = number_format((float) $produto->preco, 2, ',', '.');
        $precoCusto = number_format((float) $produto->custo, 2, ',', '.');
        $estoqueAtual = number_format((float) $produto->estoque_atual, 2, ',', '.');
        $estoqueMinimo = number_format((float) $produto->estoque_minimo, 2, ',', '.');

        return view('produtos/produtos_cadastro', ['produto' => $produto, 'unidades' => $unidades, 'preco' => $precoVenda, 'custo' => $precoCusto, 'estoque_atual' => $estoqueAtual,  'estoque_minimo' => $estoqueMinimo]);
    }

    //Função para salvar o Produto no Banco de Dados
    public function salvar(){
        $produtoModel = new ProdutoModel();
        $data = $this->request->getPost(); //Pega os dados enviados no formulário
        $id = $this->request->getPost('id'); // Pega apenas o Id enviado no formulário
        $codigo = $this->request->getPost('codigo'); // Pega apenas o Id enviado no formulário=

        //Se o id vier vazio, é produto novo
        if(empty($id)){
            //Verifica se existe um produto com esse codigo, mesmo excluído
            $produtoExistente = $this->produtoModel->withDeleted()->where('codigo', $codigo)->first(); 

            //Se existe...
            if($produtoExistente){
                if ($produtoExistente->deletado_em !== null) { //Se ele está excluído atualmente...
                    return $this->response->setJSON([ //Daremos opção de restaurar
                        'status'   => 'restore',
                        'mensagem' => 'Esse Código já existe e está excluído. Deseja restaurar o cadastro?',
                        'id'       => $produtoExistente->id
                    ]);
                }
                //Existe um produto com esse codigo
                return $this->response->setJSON([
                    'status'   => 'error',
                    'errors' => ['codigo' => 'Já existe um Produto com esse código.']
                ]);
            }
            $retorno = $produtoModel->insert($data);
        }else{ // Atualiza produto
            $retorno = $produtoModel->update($id, $data);
        }

        //Verifica se houve erros na validação
        if($retorno === false){
            //Retorna os erros de validação
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $produtoModel->errors()
            ]);
        }
        //Retorno com sucesso
        return $this->response->setJSON([
            'status' => 'success',
            'mensagem' => 'Produto salvo com sucesso!'
        ]);
    }

    //Listar os produtos cadastrados
    public function listar(){
        $id_empresa = 1;

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

        $data = [];
        if($id === null){
            $data = [
                'status' => 'error',
                'mensagem' => 'Id do produto não informado',
            ];
        }
        //Informado o Id, então busca o produto
        $produto = $this->produtoModel->find($id);

        //Se não encontrar o produto
        if (!$produto) {
            $data = [
                'status' => 'error',
                'mensagem' => 'Produto não encontrado',
            ];
        }

        //Tudo certo, deletar produto
        $this->produtoModel->delete($id);
        $data = [
                'status' => 'success',
                'mensagem' => 'Produto excluído com sucesso',
        ];

        return $this->response->setJSON($data);
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