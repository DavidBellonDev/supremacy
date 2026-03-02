<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriarTabelaUsuarios extends Migration
{
    public function up(){
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true, ],
            'nome' => ['type' => 'VARCHAR', 'constraint' => '150',],
            'sobrenome' => ['type' => 'VARCHAR', 'constraint' => '150',],
            'usuario' => ['type' => 'VARCHAR', 'constraint' => '50',],
            'telefone' => ['type' => 'VARCHAR','constraint' => '13', 'null' => true,],
            'celular' => [ 'type' => 'VARCHAR', 'constraint' => '14', 'null' => true,],
            'email' => ['type' => 'VARCHAR','constraint' => '100', ],
            'id_empresa' => ['type' => 'INT', 'constraint' => 5,'unsigned' => true, 'null' => false,],
            'senha' => ['type' => 'VARCHAR', 'constraint' => '255',],
            'privilegio' => ['type' => 'VARCHAR', 'constraint' => '50',],
            'criado_em' => ['type' => 'DATETIME', 'null' => true,],
            'atualizado_em' => ['type' => 'DATETIME', 'null' => true,],
            'deletado_em' => ['type' => 'DATETIME', 'null' => true,],
        ]);

        $this->forge->addKey('id', true); //Adicionar id como chave
        $this->forge->addUniqueKey('usuario'); //O Usuario é único, não pode repetir
        $this->forge->addUniqueKey('email'); //O email é único, não pode repetir
        $this->forge->createTable('usuarios');
    }

    public function down(){
        $this->forge->dropTable('usuarios');
    }
}
