<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpresaModel extends Model{

    protected $table            = 'empresas';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'App\Entities\Empresa';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nome', 'cpf', 'cnpj', 'endereco', 'numero', 'complemento', 'cidade', 'estado', 'cep', 'telefone', 'celular', 'email', 'admin', 'num_pedido'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;

    // Validation
    protected $validationRules      = [
        'id' => 'permit_empty|is_natural_no_zero',
        'nome' => 'required|max_length[150]|is_unique[empresas.nome,id,{id}]',
        'cpf'   => 'permit_empty|exact_length[11]|is_unique[empresas.cpf,id,{id}]',
        'cnpj'  => 'permit_empty|exact_length[14]|is_unique[empresas.cnpj,id,{id}]',
        'email' => 'required|valid_email|max_length[100]|is_unique[empresas.email,id,{id}]',
        'admin' => 'required|max_length[50]',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo Nome é obrigatório', 
            'is_unique' => 'Já existe uma empresa com esse nome cadastrado', ],
        'email' => [
            'required' => 'O campo Email é obrigatório',
            'is_unique' => 'Já existe uma empresa cadastrada com esse e-mail',
        ],
        'cpf' => [
            'is_unique' => 'Já existe um cadastrado com esse CPF ',
        ],
        'cnpj' => [
            'is_unique' => 'Já existe um cadastrado com esse CNPJ',
        ],
        'admin' => ['required' => 'O campo Administrador é obrigatório', ],
    ];

    protected $beforeValidation = ['validarCpfOuCnpj'];

    //Verificar se o CNPJ ou CPF foram informados
    protected function validarCpfOuCnpj(array $data){
        $cpf  = $data['data']['cpf']  ?? null;
        $cnpj = $data['data']['cnpj'] ?? null;

        if (empty($cpf) && empty($cnpj)) {
            $this->validation->setError(
                'cpf',
                'É obrigatório informar CPF ou CNPJ.'
            );
            $this->validation->setError(
                'cnpj',
                'É obrigatório informar CPF ou CNPJ.'
            );
        }
        if (!empty($cpf) && !empty($cnpj)) {
            $this->validation->setError(
                'cpf',
                'Informe apenas CPF ou CNPJ, não ambos.'
            );
            $this->validation->setError(
                'cnpj',
                'Informe apenas CPF ou CNPJ, não ambos.'
            );
        }
        return $data;
    }
}
