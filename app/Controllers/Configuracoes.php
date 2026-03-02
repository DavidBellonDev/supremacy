<?php

namespace app\Controllers;

use App\Controllers\BaseController;
use App\Models\EmpresaModel;

class Configuracoes extends BaseController{

    private $empresaModel;

    public function __construct(){
        $this->empresaModel = new \App\Models\EmpresaModel();
    }

    //Abrir a tela de configurações
    public function configuracoes(){

        $estados = ['AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas', 'BA' => 'Bahia',
            'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo', 'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso', 'MS' => 'Mato Grosso do Sul', 'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná', 'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte', 'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina', 'SP' => 'São Paulo', 'SE' => 'Sergipe', 'TO' => 'Tocantins', 'EX' => 'Exterior'
        ];

        $id_empresa = session()->get('id_empresa'); //Buscando o id da empresa do usuario logado
        $empresa = $this->empresaModel->find($id_empresa); //Corrigir o envio de Id

        return view('configuracoes/configuracoes', ['empresa' => $empresa, 'estados' => $estados]);
    }

    //Função para atualizar os dados da Empresa
    public function atualizar_empresa(){
        $empresaModel = new EmpresaModel();
        $data = $this->request->getPost();
        $id = session()->get('id_empresa'); //Pega apenas o Id da empresa na sessão
        $data['id'] = $id; //Precisa setar o id no $data para o Model validar corretamente
    
        $retorno = $empresaModel->update($id, $data); //Atualizando a empresa

        //Verifica se houve erros na validação
        if($retorno === false){
            //Retorna os erros de validação
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $empresaModel->errors()
            ]);
        }
        //Retorno com sucesso
        return $this->response->setJSON([
            'status' => 'success',
            'mensagem' => 'Empresa atualizada com sucesso!'
        ]);
    }
}
?>