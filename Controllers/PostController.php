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

    public function encerrar(){
        session_start();
        session_unset();
        session_destroy();
        $this->index();
    }

    public function exibir(string $titulo,$aviso = ""){
        $id = $this->limparEntradaDeDados($titulo);
        $titulo = str_replace("-"," ",$titulo);
        $postModel = new PostModel();
        $post = $postModel->buscarPostPorTitulo($titulo);
        $post_comentarios = $postModel->buscarPostComentarios($titulo);
        $matriz = array($post,$post_comentarios,$aviso);
        $this->carregarTemplate("post",$matriz);
    }

    public function curtir(){
        if(isset($_POST['submit_curtir']) and isset($_POST['id_postagem']) and !empty($_POST['id_postagem']) and isset($_POST['titulo']) and !empty($_POST['titulo'])){
            $id_post = $this->limparEntradaDeDados($_POST['id_postagem']);
            $titulo_post = $this->limparEntradaDeDados($_POST['titulo']);
            $postModel = new PostModel();
            $postModel->curtir($id_post);
            $this->exibir($titulo_post);
        }
    }

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

            $comentarioModel = new ComentarioModel();
            $resultado = $comentarioModel->comentar($comentarioEntidade);

            $this->exibir($titulo);
            
        }else{
            $titulo = $this->limparEntradaDeDados($_POST['titulo']);
            $erro = "Por favor, preencha todos os campos!";
            $this->exibir($titulo,$erro);
        }
    }

    // Métodos que só podem ser acessados se estiver logado como adm
    public function admin(){
        session_start();
        if((isset($_SESSION['token']) and !empty($_SESSION['token'])) and (isset($_SESSION['id_usuario']) and !empty($_SESSION['id_usuario']))){
            $postModel = new PostModel();
            $categorias = $postModel->buscarCategorias();
            $this->carregarTemplate("administrador",array($categorias,""));
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
                $categorias = $postModel->buscarCategorias();
    
                $this->carregarTemplate("administrador",array($categorias,$resultado));
                
            }else{
                $aviso = "Por favor, preencha todos os campos!";
                $postModel = new PostModel();
                $categorias = $postModel->buscarCategorias();
                $this->carregarTemplate("administrador",array($categorias,$aviso));
            }
        }else{
            $this->index();
        }
    }

    // Deve ser buscado pelo id do usuário os seus posts
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
                $postagem = $postModel->buscarPostPorId($id_postagem);
                $categorias = $postModel->buscarCategorias();
                $this->carregarTemplate("editarpost",array($postagem,$categorias,""));
            }
        }else{
            $this->index();
        }
    }

    public function atualizar(){
        session_start();
        if((isset($_SESSION['token']) and !empty($_SESSION['token'])) and (isset($_SESSION['id_usuario']) and !empty($_SESSION['id_usuario']))){
            if((isset($_POST['id_postagem']) and !empty($_POST['id_postagem'])) and (isset($_POST['titulo']) and !empty($_POST['titulo'])) and (isset($_POST['conteudo']) and !empty($_POST['conteudo'])) and (isset($_POST['categoria']) and !empty($_POST['categoria']))){
                
                $titulo = $this->limparEntradaDeDados($_POST['titulo']);
                $conteudo = $this->limparEntradaDeDados($_POST['conteudo']);
                $fk_id_categoria = $this->limparEntradaDeDados($_POST['categoria']);
                $id_postagem = $this->limparEntradaDeDados($_POST['id_postagem']);
                $id_usuario = $this->limparEntradaDeDados($_SESSION['id_usuario']);
                
                $postEntidade = new PostEntidade();
                $postEntidade->setIdPostagem($id_postagem);
                $postEntidade->setTitulo($titulo);
                $postEntidade->setFkIdCategoria($fk_id_categoria);
                $postEntidade->setConteudo($conteudo);
    
                $postModel = new PostModel();
                $resposta = $postModel->atualizar($postEntidade);

                $postagem = $postModel->buscarPostPorTitulo($titulo);
                $categorias = $postModel->buscarCategorias();
                $this->carregarTemplate("editarpost",array($postagem,$categorias,$resposta));

            }else{
                // Preencher todos os dados
                $id_postagem = $this->limparEntradaDeDados($_POST['id_postagem']);
                $postModel = new PostModel();
                $postagem = $postModel->buscarPostPorId($id_postagem);
                $categorias = $postModel->buscarCategorias();
                $resposta = "Preencha todos os dados!";
                $this->carregarTemplate("editarpost",array($postagem,$categorias,$resposta));
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