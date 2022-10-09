<?php 

class ErroController extends Controller{

    // Carrega a tela de erro para o usuário, caso a página acessada não exista!
    public function erro(){
        $this->carregarTemplate("erro_404",array());
    }

}