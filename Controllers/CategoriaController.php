<?php

class CategoriaController extends Controller{

    public function index(){
        $postController = new PostController();
        $postController->index();
    }

    // Mostra as postagens apenas de uma determinada categoria
    public function categoria(string $categoria){
        $categoria = $this->limparEntradaDeDados($categoria);

        $postModel = new PostModel();
        $categoriaModel = new CategoriaModel();

        $usuario_postagens = $postModel->listarUsuarioPostagensDaCategoria($categoria);
        $destaques = $postModel->listarDestaques();
        $categorias = $categoriaModel->listarCategorias();

        $matriz = array($usuario_postagens,$destaques,$categorias);
        $this->carregarTemplate("home",$matriz);
    }

    private function limparEntradaDeDados($valor){
        $valor = trim($valor);
        $valor = stripslashes($valor);
        $valor = htmlspecialchars($valor);
        return $valor;
    }
    
}