<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriarTabelaProduto extends Migration
{
    public function up(){
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true, ],
            'codigo' => ['type' => 'VARCHAR', 'constraint' => 15],
            'descricao' => ['type' => 'VARCHAR', 'constraint' => 50, ],
            'descricao_adicional' => ['type' => 'TEXT', 'null' => true,],
            'preco' => ['type' => 'DECIMAL', 'constraint' => '10,5', 'default' => 0.00,],
            'estoque_minimo' => ['type' => 'DECIMAL', 'constraint' => '10,5', 'default' => 0.00,],
            'estoque_atual' => ['type' => 'DECIMAL', 'constraint' => '10,5', 'default' => 0.00, ],
            'unidade' => ['type' => 'VARCHAR', 'constraint' => 5, ],
            'custo' => ['type' => 'DECIMAL', 'constraint' => '10,5', 'default' => 0.00, ],
            'observacao' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true,],
            'ativo' => ['type' => 'TINYINT', 'default' => 1,],
            'id_empresa' => ['type' => 'INT', 'constraint' => 5,'unsigned' => true, 'null' => false,],
            'criado_em' => ['type' => 'DATETIME', 'null' => true,],
            'atualizado_em' => ['type' => 'DATETIME', 'null' => true,],
            'deletado_em' => ['type' => 'DATETIME', 'null' => true,],
        ]);
        $this->forge->addKey('id', true); //Adicionar id como chave
        $this->forge->createTable('produtos');
    }

    public function down(){
        $this->forge->dropTable('produtos');
    }
}
