<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriarTabelaEmpresas extends Migration
{
    public function up(){
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true, ],
            'nome' => ['type' => 'VARCHAR', 'constraint' => '150',],
            'cpf' => ['type' => 'CHAR', 'constraint' => '11', 'null' => true,],
            'cnpj' => ['type' => 'CHAR', 'constraint' => '14', 'null' => true,],
            'endereco' => ['type' => 'VARCHAR', 'constraint' => '150',],
            'numero' => ['type' => 'VARCHAR', 'constraint' => '10', ],
            'complemento' => ['type' => 'VARCHAR','constraint' => '100',],
            'cidade' => ['type' => 'VARCHAR','constraint' => '50',],
            'estado' => ['type' => 'VARCHAR','constraint' => '2',],
            'cep' => ['type' => 'VARCHAR','constraint' => '10', ],
            'telefone' => ['type' => 'VARCHAR','constraint' => '13',],
            'celular' => [ 'type' => 'VARCHAR', 'constraint' => '14', ],
            'email' => ['type' => 'VARCHAR','constraint' => '100', ],
            'admin' => ['type' => 'VARCHAR', 'constraint' => '50',],
        ]);

        $this->forge->addKey('id', true); //Adicionar id como chave
        $this->forge->addUniqueKey('nome'); //O nome é único, não pode repetir
        $this->forge->addUniqueKey('cpf'); //O cpf é único, não pode repetir
        $this->forge->addUniqueKey('cnpj'); //O cnpj é único, não pode repetir
        $this->forge->addUniqueKey('email'); //O email é único, não pode repetir
        $this->forge->createTable('empresas');
    }

    public function down(){
        $this->forge->dropTable('empresas');
    }
}
