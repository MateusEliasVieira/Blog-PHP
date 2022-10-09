<?php

class Controller{

    public array $dados;

    // Construtor inicia array zerado
    public function __construct(){
        $this->dados = array();
    }

    // Carrega o template de adm ou usuário dependendo do seu nome
    public function carregarTemplate($nome_view, $dados){
        if($nome_view == "administrador" || $nome_view == "novopost" ||$nome_view == "editarpost"  || $nome_view == "meusposts" || $nome_view == "configuracoes"){
            require "Views/template-adm.php";
        }else{
            require "Views/template.php";
        }
    }

    // Carrega a view dentro do template
    public function carregarViewNoTemplate($nome_view,$dados){
        require "Views/".$nome_view.".php";
    }

    // Limpa dados vindos do front-end
    protected function limparEntradaDeDados($valor){
        $valor = trim($valor);
        $valor = stripslashes($valor);
        $valor = htmlspecialchars($valor);
        return $valor;
    }

}