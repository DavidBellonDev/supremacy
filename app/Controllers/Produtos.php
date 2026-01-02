<?php

namespace app\Controllers;

use App\Controllers\BaseController;

class Produtos extends BaseController{
    public function produtos(): string {
        return view('produtos/produtos');
    }
}

?>