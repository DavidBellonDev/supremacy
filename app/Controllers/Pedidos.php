<?php

namespace app\Controllers;

use App\Controllers\BaseController;

class Pedidos extends BaseController{
    public function pedidos(): string {
        return view('pedidos/pedidos');
    }

    public function pedidos_cadastro(): string {
        $data = [
            'aba_ativa' => 'principal',
        ];
        return view('pedidos/pedidos_cadastro', $data);
    }

    public function cadastrar(): string {
        return view('pedidos/pedidos');
    }
}

?>