<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterarTabelaEmpresas extends Migration
{
    public function up(){
        $this->forge->addColumn('empresas', [
            'num_pedido' => ['type' => 'INT', 'constraint' => 5,'unsigned' => true, 'null' => false,],
        ]);
    }

    public function down()
    {
        //
    }
}
