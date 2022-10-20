<?php

class CategoriaController extends Controller{

    // Chama o método para mostrar a view home de post controller
    public function index(){
        $postController = new PostController();
        $postController->index();
    }

    // Mostra as postagens apenas de uma determinada categoria
    public function categoria(string $categoria=""){

        if(!empty($categoria)){
            $categoria = $this->limparEntradaDeDados($categoria);
    
            $postModel = new PostModel();
            $categoriaModel = new CategoriaModel();
    
            $usuario_postagens = $postModel->listarUsuarioPostagensDaCategoria($categoria);
            $destaques = $postModel->listarDestaques();
            $categorias = $categoriaModel->listarCategorias();
    
            $matriz = array($usuario_postagens,$destaques,$categorias);
            $this->carregarTemplate("home",$matriz);
        }else{
            header("Location: http://localhost/blog/");
        }
    }

 
    
}