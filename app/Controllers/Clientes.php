<?php

namespace app\Controllers;

use App\Controllers\BaseController;

class Clientes extends BaseController{
    public function clientes(): string {
        return view('clientes/clientes');
    }
}

?>