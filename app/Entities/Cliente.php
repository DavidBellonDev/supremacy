<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Cliente extends Entity
{
    protected $attributes = [
        'id'         => null,
        'id_empresa' => null,
        'nome'       => null,
        'cpf'        => null,
        'cnpj'       => null,
        'endereco'   => null,
        'numero'     => null,
        'complemento'=> null,
        'cidade'     => null,
        'estado'     => null,
        'cep'        => null,
        'telefone'   => null,
        'celular'    => null,
        'rg'         => null, 
        'email'      => null,
        'ativo'      => true,
        'criado_em'  => null,
        'atualizado_em' => null,
        'deletado_em'   => null,
    ];

    protected $dates   = ['criado_em', 'atualizado_em', 'deletado_em'];

    protected $casts = [
        'ativo' => 'boolean',
    ];

}