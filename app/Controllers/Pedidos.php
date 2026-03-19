<?php

namespace app\Controllers;
use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Services\PedidoService;
use DomainException;
use App\Exceptions\ValidationException;
use Dompdf\Dompdf;

class Pedidos extends BaseController{
    public function pedidos(): string {
        return view('pedidos/pedidos');
    }

    private $pedidoModel;
    private $itemModel;

    public function __construct(){
        $this->pedidoModel = new \App\Models\PedidoModel();
        $this->itemModel = new \App\Models\ItemModel();
    }

    public function pedidos_cadastro(int $id = null) {

        $status = ['V' => 'Vendas', 'O' => 'Orçamento'];

        //É um cadastro novo
        if($id === null || $id === 0){
            return view('pedidos/pedidos_cadastro', ['status' => $status, 'aba_ativa' => 'principal']);
        }

        try{
            //Teste de erro forçado
            //throw new \Exception('Erro forçado para teste');

            $service = new PedidoService();
            $data = $service->pedidos_cadastro($id, session()->get('id_empresa'));
            $pedido = $data['pedido'];
            $totalItens = $data['totalItens'];
 
            return view('pedidos/pedidos_cadastro', ['pedido' => $pedido, 'status' => $status, 'aba_ativa' => 'principal', 'total' => $pedido->total, 'desconto' => $pedido->desconto, 'total_itens' => $totalItens]); 
        }catch(\DomainException $e){
            //Envia para página padrão 'Não encontrada'
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }catch(\Throwable $e){
            log_message('error', json_encode(['acao' => 'Pedido Cadastro', 'pedido_id' => $id, 'empresa_id' => session()->get('id_empresa'), 'erro' => $e->getMessage(),]));
            throw $e; 
        }
    }

    //Função para Salvar o Pedido
    public function salvar(){

        $data = $this->request->getPost(); //Pega os dados enviados no formulário
        try{
            $service = new PedidoService();
            $retorno = $service->salvar($data, session()->get('id_empresa'));
            return $this->response->setStatusCode(200)->setJSON([
                'status' => 'success',
                'mensagem' => 'Pedido salvo com sucesso!',
                'acao' => $retorno['acao'],
                'idNovoPedido' => $retorno['idNovoPedido'],
                'numeroPedido' => $retorno['numeroPedido'],
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
        }catch(\Throwable $e){
            log_message('error', json_encode(['acao' => 'Salvar Pedido', 'pedido_id' => $this->request->getPost('id'), 'empresa_id' => session()->get('id_empresa'), 'erro' => $e->getMessage(),]));

            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'mensagem' => 'Erro interno'
            ]);
        }
    }

    //Função para Listar os pedidos salvos separando pela empresa a que pertencem 
    public function listar(){
        $id_empresa = session()->get('id_empresa');

        $atributos = ['id', 'pedido', 'nome_cliente', 'status', 'total', 'finalizado', 'id_empresa'];

        $pedidos = $this->pedidoModel->select($atributos)->where('id_empresa', $id_empresa)->withDeleted(false)->orderBy('id', 'DESC')->findAll();
        $data = [];
        foreach ($pedidos as $p) {
            $data[] = [
                'id' => $p->id,
                'pedido' => $p->pedido,
                'nome_cliente' => $p->nome_cliente, 
                'status' => $p->status,
                'total' => $p->total,
                'finalizado' => $p->finalizado ? 'Sim' : 'Não',
                'id_empresa' => $p->id_empresa,
            ];
        }
        return $this->response->setJSON(['data' => $data]);
    }

    //Função para Excluir o pedido
    public function excluir(int $id = null){
        try{
            $service = new PedidoService();
            $service->excluir($id, session()->get('id_empresa'));
            return $this->response->setJSON([
                'status' => 'success',
                'mensagem' => 'Pedido excluído com sucesso!'
            ]);
        }catch(\DomainException $e){
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'errors' => [
                    '_global' => $e->getMessage()
                ]
            ]);
        }catch(\Throwable $e){
            log_message('error', json_encode(['acao' => 'Excluir Pedido', 'pedido_id' => $id, 'empresa_id' => session()->get('id_empresa'), 'erro' => $e->getMessage(),]));

            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'mensagem' => 'Erro interno'
            ]);
        }
    }

    //Função para Finalizar um pedido
    public function finalizar(int $id = null){

        try{
            $service = new PedidoService();
            $service->finalizar($id, session()->get('id_empresa'));
            return $this->response->setJSON([
                'status' => 'success',
                'mensagem' => 'Pedido finalizado com sucesso!'
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
        }catch(\Throwable $e){
            log_message('error', json_encode(['acao' => 'Finalizar Pedido', 'pedido_id' => $id, 'empresa_id' => session()->get('id_empresa'), 'erro' => $e->getMessage(),]));

            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'mensagem' => 'Erro interno'
            ]);
        }
    }

    //Gerar PDF do Pedido
    public function gerarPDF($id){
        $pedidoModel = new \App\Models\PedidoModel();
        $itemModel = new \App\Models\ItemModel();

        $pedido = $pedidoModel->find($id);
        $itens = $itemModel->where('id_pedido', $id)->findAll();

        $html = view('pedidos/pedido_pdf', [
            'pedido' => $pedido,
            'itens'  => $itens
        ]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setBody($dompdf->output());
    }
}
?>