<?php

namespace app\Controllers;

use App\Controllers\BaseController;

class Home extends BaseController{
    public function home(): string {
        return view('home/home');
    }
}

?>