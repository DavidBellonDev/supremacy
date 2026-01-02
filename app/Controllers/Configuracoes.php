<?php

namespace app\Controllers;

use App\Controllers\BaseController;

class Configuracoes extends BaseController{
    public function configuracoes(): string {
        return view('configuracoes/configuracoes');
    }
}

?>