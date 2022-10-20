<?php

class PostController extends Controller{

    // Busca os dados para mostrar na view home.php
    public function index(){
        $postModel = new PostModel();
        $categoriaModel = new CategoriaModel();

        $usuario_postagens = $postModel->listarUsuarioPostagens();
        $destaques = $postModel->listarDestaques();
        $categorias = $categoriaModel->listarCategorias();

        $matriz = array($usuario_postagens,$destaques,$categorias);
        $this->carregarTemplate("home",$matriz);
    }

    // Redireciona para a página da postagem em específica, após clicada nela
    public function exibir(string $titulo="", $aviso = ""){
        
        if(!empty($titulo)) {
            $titulo = $this->limparEntradaDeDados($titulo);
            $titulo = str_replace("-"," ",$titulo);
            $postModel = new PostModel();
            $postModel->atualizarVisualizacoes($titulo);
            $postagem = $postModel->buscarPostPorTitulo($titulo);
            $postagem_comentarios = $postModel->buscarPostComentarios($titulo);
            $matriz = array($postagem,$postagem_comentarios, $aviso);
            $this->carregarTemplate("post",$matriz);
        }else{
            header("Location: http://localhost/blog/");
        }
    }

    // Curte uma postagem
    public function curtir(){
        if(isset($_POST['submit_curtir']) and isset($_POST['id_postagem']) and !empty($_POST['id_postagem']) and isset($_POST['titulo']) and !empty($_POST['titulo'])){
            $id_post = $this->limparEntradaDeDados($_POST['id_postagem']);
            $titulo_post = $this->limparEntradaDeDados($_POST['titulo']);
            $postModel = new PostModel();
            $postModel->curtir($id_post);
            header('Location: http://localhost/blog/post/exibir/'.str_replace(" ","-",$titulo_post)."#box-info-post");
        }
    }

    // Comenta uma postagem
    public function comentar(){
        if(isset($_POST['id_postagem']) and !empty($_POST['id_postagem']) and isset($_POST['nome']) and !empty($_POST['nome']) and isset($_POST['comentario']) and !empty($_POST['comentario']) and isset($_POST['titulo']) and !empty($_POST['titulo'])){
            $id_postagem = $this->limparEntradaDeDados($_POST['id_postagem']);
            $nome = $this->limparEntradaDeDados($_POST['nome']); 
            $mensagem = $this->limparEntradaDeDados($_POST['comentario']); 
            $data_comentario = date("Y-m-d H:i:s");
            $titulo = $this->limparEntradaDeDados($_POST['titulo']);

            $comentarioEntidade = new ComentarioEntidade();
            $comentarioEntidade->setNome($nome);
            $comentarioEntidade->setMensagem($mensagem);
            $comentarioEntidade->setDataComentario($data_comentario);
            $comentarioEntidade->setFkIdPostagem($id_postagem);

            $postModel = new PostModel();
            $resultado = $postModel->comentar($comentarioEntidade);

            header('Location: http://localhost/blog/post/exibir/'.str_replace(" ","-",$titulo)."#box-info-post");
            
        }else{
            $titulo = $this->limparEntradaDeDados($_POST['titulo']);
            $erro = "Por favor, preencha todos os campos!";
            $this->exibir($titulo,$erro);
        }
    }

}