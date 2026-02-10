<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table            = 'itens';
    protected $returnType       = 'App\Entities\Item';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['id_pedido', 'descricao_produto', 'valor', 'quantidade', 'desconto', 'total', 'observacao', 'id_empresa', 'id_usuario', 'nome_usuario', 'deletado_em', 'id_produto'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validation
    protected $validationRules      = [
        'id' => 'permit_empty|is_natural_no_zero',          //permit_empty = pode ir vazio, exemp. INSERT
        'id_pedido'=> 'required|is_natural_no_zero',        //is_natural_no_zero = se preenchido deve ser > 0
        'descricao_produto' => 'required|max_length[150]',  //required = Valor obrigatório
        'id_produto' => 'required|is_natural_no_zero',
        'id_empresa'=> 'required|is_natural_no_zero',
        'id_usuario'=> 'required|is_natural_no_zero',
        'nome_usuario'=> 'required',
        'valor' => 'required|greater_than[0]',
        'quantidade' => 'required|greater_than[0]',
        'total' => 'required|greater_than[0]',
    ];
    protected $validationMessages   = [
        'descricao_produto' => [
            'required' => 'O campo Produto é obrigatório', 
        ],
        'valor' => [
            'required' => 'O campo Valor é obrigatório', 
            'greater_than' => 'O Valor do Item não pode ser Zero ou menor',
        ],
        'quantidade' => [
            'required' => 'O campo Quantidade é obrigatório', 
            'greater_than' => 'A Quantidade do Item não pode ser Zero ou menor',
        ],
        'total' => [
            'required' => 'O campo Total é obrigatório', 
            'greater_than' => 'O Total do Item não pode ser Zero ou menor',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
