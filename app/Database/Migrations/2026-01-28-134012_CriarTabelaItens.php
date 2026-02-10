<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriarTabelaItens extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true, ],
            'id_pedido' => ['type' => 'INT', 'constraint' => 5,'unsigned' => true, 'null' => false,],
            'descricao_produto' => ['type' => 'VARCHAR', 'constraint' => '150',],
            'valor' => ['type' => 'DECIMAL', 'constraint' => '10,5', 'default' => 0.00, ],
            'quantidade' => ['type' => 'DECIMAL', 'constraint' => '10,5', 'default' => 0.00, ],
            'desconto' => ['type' => 'DECIMAL', 'constraint' => '10,5', 'default' => 0.00, ],
            'total' => ['type' => 'DECIMAL', 'constraint' => '10,5', 'default' => 0.00, ],
            'observacao' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true,],
            'id_empresa' => ['type' => 'INT', 'constraint' => 5,'unsigned' => true, 'null' => false,],
            'id_usuario' => ['type' => 'INT', 'constraint' => 5,'unsigned' => true, 'null' => false,],
            'nome_usuario' => ['type' => 'VARCHAR', 'constraint' => '150',],
            'criado_em' => ['type' => 'DATETIME', 'null' => true,],
            'atualizado_em' => ['type' => 'DATETIME', 'null' => true,],
            'deletado_em' => ['type' => 'DATETIME', 'null' => true,],
        ]);
        $this->forge->addKey('id', true); //Adicionar id como chave
        $this->forge->createTable('itens');
    }

    public function down(){
        $this->forge->dropTable('itens');
    }
}
