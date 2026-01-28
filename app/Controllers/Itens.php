<?php 

namespace app\Controllers;
use App\Controllers\BaseController;
use App\Models\ItemModel;

class Itens extends BaseController{

    private $itemModel;

    public function __construct(){
        $this->itemModel = new \App\Models\ItemModel();
    }

}    

?>