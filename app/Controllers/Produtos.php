<?php

namespace app\Controllers;

use App\Controllers\BaseController;

class Produtos extends BaseController{
    public function produtos(): string {
        return view('produtos/produtos');
    }

    public function produtos_cadastro(): string {
        return view('produtos/produtos_cadastro');
    }

    public function cadastrar(): string {
        return view('produtos/produtos');
    }
}

?>