<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdProdutoTabelaItens extends Migration
{
    public function up() {
        $this->forge->addColumn('itens', [
            'id_produto' => ['type' => 'INT', 'constraint' => 5,'unsigned' => true, 'null' => false,],
        ]);
    }

    public function down(){
        $this->forge->dropColumn('itens', 'finaid_produtolizado');
    }
}
