<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriarTabelaCliente extends Migration{

    public function up(){
       $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true,],
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
            'rg' => ['type' => 'VARCHAR', 'constraint' => '20',],
            'email' => ['type' => 'VARCHAR','constraint' => '100', ],
            'ativo' => ['type' => 'BOOLEAN', 'null' => false, ],
            'id_empresa' => ['type' => 'INT', 'constraint' => 5,'unsigned' => true,'null' => false,],
            'criado_em' => ['type' => 'DATETIME', 'null' => true,],
            'atualizado_em' => ['type' => 'DATETIME', 'null' => true,],
            'deletado_em' => ['type' => 'DATETIME', 'null' => true,],
       ]);

       $this->forge->addKey('id', true); //Adicionar id como chave
       $this->forge->addUniqueKey('cpf'); //O cpf é único, não pode repetir
       $this->forge->addUniqueKey('cnpj'); //O cnpj é único, não pode repetir

       $this->forge->createTable('clientes');
    }

    public function down(){
        $this->forge->dropTable('clientes');
    }
}
