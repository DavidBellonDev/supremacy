<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $table            = 'produtos';
    protected $returnType       = 'App\Entities\Produto';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['codigo', 'descricao', 'descricao_adicional', 'preco', 'estoque_minimo', 'estoque_atual', 'unidade', 'custo', 'observacao', 'ativo', 'id_empresa', 'deletado_em'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = ['ativo' => 'boolean',];
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
        'codigo' => 'required|max_length[15]',
        'descricao' => 'required|max_length[50]',
        'descricao_adicional' => 'max_length[300]',
        'observacao' => 'max_length[150]',
    ];
    protected $validationMessages   = [
       'codigo' => [
            'required'   => 'O campo Código é obrigatório',
            'max_length' => 'O campo Código deve ter no máximo 15 caracteres',
        ],
        'descricao' => ['required' => 'O campo Descrição é obrigatório',
            'max_length' => 'O campo Descrição deve ter no máximo 50 caracteres', 
        ],
        'descricao_adicional' => ['max_length' => 'O campo Descrição Adicional deve ter no máximo 300 caracteres', ],
        'observacao' => ['max_length' => 'O campo Observação deve ter no máximo 150 caracteres', ],
    ];
}
