<?php

namespace App\Models;
use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table            = 'clientes';
    protected $returnType       = 'App\Entities\Cliente';
    protected $useSoftDeletes   = true; //False = Quando dado for deletado, apaga em definitivo. True = Mantem salvo;
    protected $allowedFields    = ['nome', 'cpf', 'cnpj', 'endereco', 'numero', 'complemento', 'cidade', 'estado', 'cep', 'telefone', 'celular', 'rg', 'email', 'ativo', 'id_empresa', 'deletado_em'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'ativo' => 'boolean',
    ];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validation
    protected $validationRules      = [
        'id' => 'permit_empty|is_natural_no_zero',
        'id_empresa'=> 'required|is_natural_no_zero',
        'nome' => 'required|max_length[150]',
        'cpf'   => 'permit_empty|exact_length[11]',
        'cnpj'  => 'permit_empty|exact_length[14]',
        'email' => 'permit_empty|valid_email|max_length[100]',

    ];
    protected $validationMessages   = [
        'nome' => ['required' => 'O campo Nome é obrigatório', ],
    ];

    //Converter CPF ou CNPJ em Null
    protected $beforeInsert = ['cpfOuCnpjVazioParaNull'];
    protected $beforeUpdate = ['cpfOuCnpjVazioParaNull'];

    protected function cpfOuCnpjVazioParaNull(array $data){
        if(isset($data['data']['cpf']) && $data['data']['cpf'] === ''){
            $data['data']['cpf'] = null;
        }
        if(isset($data['data']['cnpj']) && $data['data']['cnpj'] === ''){
            $data['data']['cnpj'] = null;
        }

        return $data;
    }
}
