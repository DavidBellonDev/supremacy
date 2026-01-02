<?php

namespace app\Controllers;

use App\Controllers\BaseController;

class Vendas extends BaseController{
    public function vendas(): string {
        return view('vendas/vendas');
    }
}

?>