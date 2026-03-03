<?php 

namespace App\Services;
use App\Models\ProdutoModel;
use DomainException;
use App\Exceptions\ValidationException;

class ProdutoService{

    private ProdutoModel $produtoModel;

    public function __construct(){
        $this->produtoModel = new ProdutoModel();
    }

    //Função para abrir o cadastro de produtos
    public function produtos_cadastro(int $id, int $idEmpresa){
        //Verificar se o cadastro pertence a empresa do usuário logado
        $produto = $this->produtoModel->where('id_empresa', $idEmpresa)->find($id);

        //Se não pertencer, dar mensagem de erro
        if(!$produto){
            throw new DomainException('Produto não encontrado');
        }   

        return $produto;
    }

    //Função para salvar o produto
    public function salvar(array $data, int $idEmpresa){

        //Compara os id_empresa recebidos
        if($data['id_empresa'] != $idEmpresa){
            throw new DomainException('Não posso prosseguir com o cadastro por inconsistência nos dados');
        }

        //Verifica se existe um produto com esse codigo, mesmo excluído
        $produtoExistente = $this->produtoModel->withDeleted()->where('codigo', $data['codigo'])->first(); 

        //Se existe...
        if($produtoExistente){
            if ($produtoExistente->deletado_em !== null) { //Se ele está excluído atualmente...
                return [ //Daremos opção de restaurar
                    'status'   => 'restore',
                    'id'       => $produtoExistente->id
                ];
            }
        }

        //Se o id vier vazio, é produto novo
        if(empty($data['id'])){
            $retorno = $this->produtoModel->insert($data);
        }else{ // Atualiza produto
            $retorno = $this->produtoModel->update($data['id'], $data);
        }

        //Verifica se houve erros na validação
        if($retorno === false){
            //Retorna os erros de validação
            throw new ValidationException($this->produtoModel->errors());
        }
        //Retorno com sucesso
        return true;
    }

    //Função para Excluir o Produto
    public function excluir(int $idProduto, int $idEmpresa){

        //Informando o id e então buscando o produto
        $produto = $this->produtoModel->where('id', $idProduto)->where('id_empresa', $idEmpresa)->first();

        //Se não encontrar o produto ou verificar se esse $id pertence a empresa do usuario logado
        if(!$produto || $produto->id_empresa != $idEmpresa){
            throw new DomainException('Produto não encontrado');
        }

        //Tudo certo, apagar produto
        $this->produtoModel->delete($idProduto);
    }

    //Função para restaurar produto excluído
    public function restaurar_produto(int $idProduto, int $idEmpresa){
        $produto = $this->produtoModel->withDeleted()->where('id', $idProduto)->where('id_empresa', $idEmpresa)->first(); 

        if(!$produto){
            throw new DomainException('Produto não encontrado');
        }

        if($produto->id_empresa != $idEmpresa){
            throw new DomainException('Produto não encontrado');
        }

        $this->produtoModel->update($idProduto, ['deletado_em' => null]);

    }
}

?>