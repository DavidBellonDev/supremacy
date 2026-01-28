<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table            = 'pedidos';
    protected $returnType       = 'App\Entities\Pedido';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['pedido', 'status', 'id_cliente', 'nome_cliente', 'cpf_cliente', 'cnpj_cliente', 'endereco_cliente', 'numero_cliente', 'complemento_cliente', 'cidade_cliente', 'estado_cliente', 'total', 'desconto', 'observacao', 'finalizado', 'id_empresa', 'id_usuario', 'nome_usuario', 'deletado_em'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = ['finalizado' => 'boolean',];
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
        'observacao' => 'max_length[150]',
    ];
    protected $validationMessages   = [
        'observacao' => ['max_length' => 'O campo Observação deve ter no máximo 150 caracteres', ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
