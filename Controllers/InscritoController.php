<?php


class InscritoController extends Controller{

    // Busca os dados para mostrar na view home.php
    public function index(string $mensagem){
        $postModel = new PostModel();
        $categoriaModel = new CategoriaModel();
    
        $usuario_postagens = $postModel->listarUsuarioPostagens();
        $destaques = $postModel->listarDestaques();
        $categorias = $categoriaModel->listarCategorias();
    
        $matriz = array($usuario_postagens,$destaques,$categorias,$mensagem);
        $this->carregarTemplate("home",$matriz);
    }

    public function inscrever(){
        
        if(isset($_POST['email']) and !empty($_POST['email']) and $_POST['email'] != null){
            
            $email = $this->limparEntradaDeDados($_POST['email']);
           
            $inscritoEntidade = new InscritoEntidade();
            $inscritoEntidade->setEmail($email);
            $inscritoEntidade->setDataInscricao(date("Y-m-d H:i:s"));
            $inscritoEntidade->setPermissao(true);
            
            $inscritoModel = new InscritoModel();
    
            if($inscritoModel->inscrever($inscritoEntidade)){
                $this->index("Inscrição realizada com sucesso!");
            }else{
                $this->index("Este email já esta cadastrado em nosso blog!");
            }
        }else{
            $this->index("Por favor, preencha o campo de email corretamente!");
        }

    }


}