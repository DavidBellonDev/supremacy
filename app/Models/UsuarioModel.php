<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $returnType       = 'App\Entities\Usuario';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['nome', 'sobrenome', 'usuario', 'telefone', 'celular', 'email', 'senha', 'id_empresa', 'privilegio', 'deletado_em', 'reset_token', 'reset_expires'];
    protected $beforeInsert = ['hashSenha'];
    protected $beforeUpdate = ['hashSenha'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validation
    protected $validationRules      = [
        'id' => 'permit_empty|is_natural_no_zero',
        'nome' => 'required|max_length[150]',
        'sobrenome' => 'required|max_length[150]',
        'email' => 'required|max_length[150]|is_unique[usuarios.email,id,{id}]',
        'usuario' => 'required|max_length[50]',
        'senha ' => 'required|max_length[255]',
        'id_empresa'=> 'required|is_natural_no_zero', 
    ];
    protected $validationMessages   = [
        'email' => [
            'required' => 'O campo Email é obrigatório',
            'is_unique' => 'Já existe um usuário cadastrado com esse e-mail',
        ],
    ];

    //Função para criar o hash da senha
    protected function hashSenha(array $data){
        if (isset($data['data']['senha'])) {
            $data['data']['senha'] = password_hash(
                $data['data']['senha'],
                PASSWORD_DEFAULT
            );
        }
        return $data;
    }

}
