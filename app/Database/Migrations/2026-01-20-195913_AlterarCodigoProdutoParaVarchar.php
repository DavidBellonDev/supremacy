<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterarCodigoProdutoParaVarchar extends Migration
{
    public function up(){
        $this->forge->modifyColumn('produtos', [
            'codigo' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
            ],
        ]);
    }

    public function down(){
        $this->forge->modifyColumn('produtos', [
            'codigo' => [
                'type' => 'INT',
            ],
        ]);
    }
}
