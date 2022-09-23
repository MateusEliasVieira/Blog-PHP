<?php

class PostController extends Controller{

    // Métodos que podem ser acessados sem estar logado como adm

    public function index(){
        $postModel = new PostModel();
        $usuario_postagens = $postModel->listarUsuarioPostagens();
        $destaques = $postModel->listarDestaques();
        $categoria = $postModel->listarCategorias();
        $matriz = array($usuario_postagens,$destaques,$categoria);
        $this->carregarTemplate("home",$matriz);
    }

    public function exibir(string $titulo,$aviso = ""){
        $id = $this->limparEntradaDeDados($titulo);
        $titulo = str_replace("-"," ",$titulo);
        $postModel = new PostModel();
        $post = $postModel->buscarPost($titulo);
        $post_comentarios = $postModel->buscarPostComentarios($titulo);
        $matriz = array($post,$post_comentarios,$aviso);
        $this->carregarTemplate("post",$matriz);
    }

    public function curtir(){
        if(isset($_POST['submit-curtir']) and isset($_POST['id-post']) and !empty($_POST['id-post']) and isset($_POST['titulo-post']) and !empty($_POST['titulo-post'])){
            $id_post = $this->limparEntradaDeDados($_POST['id-post']);
            $titulo_post = $this->limparEntradaDeDados($_POST['titulo-post']);
            $postModel = new PostModel();
            $postModel->curtir($id_post);
            $this->exibir($titulo_post);
        }
    }

    public function comentar(){
        if(isset($_POST['id-postagem']) and !empty($_POST['id-postagem']) and isset($_POST['nome-usuario']) and !empty($_POST['nome-usuario']) and isset($_POST['comentario-usuario']) and !empty($_POST['comentario-usuario']) and isset($_POST['titulo-postagem']) and !empty($_POST['titulo-postagem'])){
            $id_postagem = $this->limparEntradaDeDados($_POST['id-postagem']);
            $nome = $this->limparEntradaDeDados($_POST['nome-usuario']); 
            $mensagem = $this->limparEntradaDeDados($_POST['comentario-usuario']); 
            $data_comentario = date("Y-m-d H:i:s");
            $titulo = $this->limparEntradaDeDados($_POST['titulo-postagem']);

            $comentarioEntidade = new ComentarioEntidade();
            $comentarioEntidade->setNome($nome);
            $comentarioEntidade->setMensagem($mensagem);
            $comentarioEntidade->setDataComentario($data_comentario);
            $comentarioEntidade->setFkIdPostagem($id_postagem);

            $comentarioModel = new ComentarioModel();
            $resultado = $comentarioModel->comentar($comentarioEntidade);

            $this->exibir($titulo);
            
        }else{
            $titulo = $this->limparEntradaDeDados($_POST['titulo-postagem']);
            $erro = "Por favor, preencha todos os campos!";
            $this->exibir($titulo,$erro);
        }
    }

    // Métodos que só podem ser acessados se estiver logado como adm
    public function admin(){
        session_start();
        if((isset($_SESSION['token']) and !empty($_SESSION['token'])) and (isset($_SESSION['id_usuario']) and !empty($_SESSION['id_usuario']))){
            $this->carregarTemplate("administrador",array());
        }else{
            $this->index();
        }
    }

    public function cadastrar(){
        session_start();
        if((isset($_SESSION['token']) and !empty($_SESSION['token'])) and (isset($_SESSION['id_usuario']) and !empty($_SESSION['id_usuario']))){
            if((isset($_POST['titulo']) and !empty($_POST['titulo'])) and (isset($_POST['conteudo']) and !empty($_POST['conteudo'])) and (isset($_POST['categoria']) and !empty($_POST['categoria']))){
               
                $titulo = $this->limparEntradaDeDados($_POST['titulo']);
                $conteudo = $this->limparEntradaDeDados($_POST['conteudo']);
                $fk_id_usuario = $this->limparEntradaDeDados($_SESSION['id_usuario']);
                $fk_id_categoria = $this->limparEntradaDeDados($_POST['categoria']);
                
                $postEntidade = new PostEntidade();
                $postEntidade->setTitulo($titulo);
                $postEntidade->setConteudo($conteudo);
                $data_atual = date("Y-m-d H:i:s");
                $postEntidade->setDataPostagem($data_atual);
                $postEntidade->setCurtidas(0);
                $postEntidade->setQuantidadeComentarios(0);
                $postEntidade->setfkIdCategoria($fk_id_categoria);
                $postEntidade->setFkIdUsuario($fk_id_usuario);
    
                $postModel = new PostModel();
                $resultado = $postModel->cadastrar($postEntidade);
    
                $this->carregarTemplate("administrador",$resultado);
                
            }else{
                $aviso = "Por favor, preencha todos os campos!";
                $this->carregarTemplate("administrador",$aviso);
            }
        }else{
            $this->index();
        }
    }

    public function meusposts(){
        session_start();
        if((isset($_SESSION['token']) and !empty($_SESSION['token'])) and (isset($_SESSION['id_usuario']) and !empty($_SESSION['id_usuario']))){
           
            $id_usuario = $this->limparEntradaDeDados($_SESSION['id_usuario']); 
            $postModel = new PostModel();
            $posts = $postModel->meusposts($id_usuario);
            $this->carregarTemplate("meusposts",$posts);

        }else{
            $this->index();
        }

    }

    public function editar(){
        session_start();
        if((isset($_SESSION['token']) and !empty($_SESSION['token'])) and (isset($_SESSION['id_usuario']) and !empty($_SESSION['id_usuario']))){
            if(isset($_POST["id_postagem"]) and !empty($_POST["id_postagem"])){
                $id_postagem = $this->limparEntradaDeDados($_POST["id_postagem"]);
                $postModel = new PostModel();
                $post = $postModel->buscarPost($id_postagem);
                $this->carregarTemplate("editarpost",$post);
            }
        }else{
            $this->index();
        }
    }

    public function atualizar(){
        session_start();
        if((isset($_SESSION['token']) and !empty($_SESSION['token'])) and (isset($_SESSION['id_usuario']) and !empty($_SESSION['id_usuario']))){
            if((isset($_POST['id-postagem-atualizar']) and !empty($_POST['id-postagem-atualizar'])) and (isset($_POST['titulo']) and !empty($_POST['titulo'])) and (isset($_POST['conteudo']) and !empty($_POST['conteudo']))){
                
                $titulo = $this->limparEntradaDeDados($_POST['titulo']);
                $conteudo = $this->limparEntradaDeDados($_POST['conteudo']);
                $id_postagem = $this->limparEntradaDeDados($_POST['id-postagem-atualizar']);
                $id_usuario = $this->limparEntradaDeDados($_SESSION['id_usuario']);
                
                $postEntidade = new PostEntidade();
                $postEntidade->setIdPostagem($id_postagem);
                $postEntidade->setTitulo($titulo);
                $postEntidade->setConteudo($conteudo);
    
                $postModel = new PostModel();
                $postModel->atualizar($postEntidade);

                $meusposts = $postModel->meusposts($id_usuario);
                $this->carregarTemplate("meusposts", $meusposts);
            }else{
                $aviso = "Por favor, preencha todos os campos!";
                $this->carregarTemplate("editarpost",$aviso);
            }
        }else{
            $this->index();
        }
    }

    private function limparEntradaDeDados($valor){
        $valor = trim($valor);
        $valor = stripslashes($valor);
        $valor = htmlspecialchars($valor);
        return $valor;
    }

}