<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriarTabelaPedido extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true, ],
            'pedido' => ['type' => 'INT', 'constraint' => 8, 'null' => false, ],
            'status' => ['type' => 'VARCHAR','constraint' => '3',],
            'id_cliente' => ['type' => 'INT', 'constraint' => 5,'unsigned' => true, 'null' => false,],
            'nome_cliente' => ['type' => 'VARCHAR', 'constraint' => '150',],
            'cpf_cliente' => ['type' => 'CHAR', 'constraint' => '11', 'null' => true,],
            'cnpj_cliente' => ['type' => 'CHAR', 'constraint' => '14', 'null' => true,],
            'endereco_cliente' => ['type' => 'VARCHAR', 'constraint' => '150',],
            'numero_cliente' => ['type' => 'VARCHAR', 'constraint' => '10', ],
            'complemento_cliente' => ['type' => 'VARCHAR','constraint' => '100',],
            'cidade_cliente' => ['type' => 'VARCHAR','constraint' => '50',],
            'estado_cliente' => ['type' => 'VARCHAR','constraint' => '2',],
            'total' => ['type' => 'DECIMAL', 'constraint' => '10,5', 'default' => 0.00, ],
            'desconto' => ['type' => 'DECIMAL', 'constraint' => '10,5', 'default' => 0.00, ],
            'observacao' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true,],
            'finalizado' => ['type' => 'TINYINT', 'default' => 1,],
            'id_empresa' => ['type' => 'INT', 'constraint' => 5,'unsigned' => true, 'null' => false,],
            'id_usuario' => ['type' => 'INT', 'constraint' => 5,'unsigned' => true, 'null' => false,],
            'nome_usuario' => ['type' => 'VARCHAR', 'constraint' => '150',],
            'criado_em' => ['type' => 'DATETIME', 'null' => true,],
            'atualizado_em' => ['type' => 'DATETIME', 'null' => true,],
            'deletado_em' => ['type' => 'DATETIME', 'null' => true,],
        ]);
        $this->forge->addKey('id', true); //Adicionar id como chave
        $this->forge->createTable('pedidos');
    }

    public function down(){
        $this->forge->dropTable('pedidos');
    }
}
