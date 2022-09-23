<?php 

class ErroController extends Controller{

    public function erro(){
        $this->carregarTemplate("erro_404",array());
    }

}