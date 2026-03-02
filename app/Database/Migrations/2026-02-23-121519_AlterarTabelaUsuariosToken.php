<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterarTabelaUsuariosToken extends Migration{
    
    public function up(){
        $this->forge->addColumn('usuarios', [
            'reset_token' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true,],
            'reset_expires' => ['type' => 'DATETIME', 'null' => true,],
        ]);
    }

    public function down(){
        $this->forge->dropColumn('usuarios', ['reset_token', 'reset_expires']);
    }
}
