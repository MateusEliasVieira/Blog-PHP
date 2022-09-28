<?php

class Controller{

    public array $dados;

    public function __construct(){
        $this->dados = array();
    }

    public function carregarTemplate($nome_view, $dados){
        if($nome_view == "administrador" || $nome_view == "novopost" ||$nome_view == "editarpost"  || $nome_view == "meusposts"){
            require "Views/template-adm.php";
        }else{
            require "Views/template.php";
        }
    }

    public function carregarViewNoTemplate($nome_view,$dados){
        require "Views/".$nome_view.".php";
    }

}