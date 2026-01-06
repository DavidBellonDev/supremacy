<?php

namespace app\Controllers;

use App\Controllers\BaseController;

class Clientes extends BaseController{
    public function clientes(): string {
        return view('clientes/clientes');
    }

    public function clientes_cadastro(): string {
        return view('clientes/cliente_cadastro');
    }

    public function cadastrar(): string {
        return view('clientes/clientes');
    }
}

?>