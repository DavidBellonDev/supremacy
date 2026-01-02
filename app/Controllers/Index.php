<?php 

namespace App\Controllers;

class Index extends BaseController{
    
    public function index(): string {
        return view('index/index');
    }

    public function login(): string{
        return view('login/login');
    }
    
    public function cadastre_se(): string{
        return view('login/cadastre_se');
    }

}

?>