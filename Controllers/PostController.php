<?php

class PostController extends Controller{

    // Métodos que podem ser acessados sem estar logado como adm

    // Busca os dados para mostrar na view home.php
    public function index(){
        $postModel = new PostModel();
        $usuario_postagens = $postModel->listarUsuarioPostagens();
        $destaques = $postModel->listarDestaques();
        $categorias = $postModel->listarCategorias();
        $matriz = array($usuario_postagens,$destaques,$categorias);
        $this->carregarTemplate("home",$matriz);
    }

    // Redireciona para a página da postagem em específica, após clicada nela
    public function exibir(string $titulo, $aviso = ""){
        $titulo = $this->limparEntradaDeDados($titulo);
        $titulo = str_replace("-"," ",$titulo);
        $postModel = new PostModel();
        $postagem = $postModel->buscarPostPorTitulo($titulo);
        $postagem_comentarios = $postModel->buscarPostComentarios($titulo);
        $matriz = array($postagem,$postagem_comentarios, $aviso);
        $this->carregarTemplate("post",$matriz);
    }

    // Mostra as postagens apenas de uma determinada categoria
    public function categoria(string $categoria){
        $categoria = $this->limparEntradaDeDados($categoria);
        $postModel = new PostModel();
        $usuario_postagens = $postModel->listarUsuarioPostagensDaCategoria($categoria);
        $destaques = $postModel->listarDestaques();
        $categorias = $postModel->listarCategorias();
        $matriz = array($usuario_postagens,$destaques,$categorias);
        $this->carregarTemplate("home",$matriz);
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

            $postModel = new PostModel();
            $resultado = $postModel->comentar($comentarioEntidade);

            $this->exibir($titulo);
            
        }else{
            $titulo = $this->limparEntradaDeDados($_POST['titulo']);
            $erro = "Por favor, preencha todos os campos!";
            $this->exibir($titulo,$erro);
        }
    }

    // Métodos que só podem ser acessados se estiver logado como adm

    public function administrador(){
        session_start();
        if((isset($_SESSION['token']) and !empty($_SESSION['token'])) and (isset($_SESSION['id_usuario']) and !empty($_SESSION['id_usuario']))){
            $postModel = new PostModel();
            $qtd_usuario = $postModel->qtd_usuario();
            $qtd_categoria = $postModel->qtd_categoria();
            $qtd_postagem = $postModel->qtd_postagem();    
            $this->carregarTemplate("administrador",array($qtd_usuario,$qtd_categoria,$qtd_postagem));
        }else{
            $this->index();
        }
    }

    public function usuario(){
        session_start();
        
        $erros = array();

        if((isset($_SESSION['token']) and !empty($_SESSION['token'])) and (isset($_SESSION['id_usuario']) and !empty($_SESSION['id_usuario']))){
           
            // Verificar se existem os campos vindos do formulário
            if(isset($_POST['nome']) and isset($_POST['email']) and isset($_POST['whatsapp']) and isset($_POST['instagram']) and isset($_POST['twitter']) and isset($_POST['facebook']) and isset($_POST['youtube']) and isset($_POST['senha']) and isset($_POST['repete_senha']) and isset($_POST['sobre'])){
                
                // Obtendo os valores e limpando
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $whatsapp = $_POST['whatsapp'];
                $instagram = $_POST['instagram'];
                $twitter = $_POST['twitter'];
                $facebook = $_POST['facebook'];
                $youtube = $_POST['youtube'];
                $sobre = filter_input(INPUT_POST,'sobre',FILTER_SANITIZE_SPECIAL_CHARS);
                $senha = $_POST['senha'];
                $repete_senha = $_POST['repete_senha'];
                
                // Campos obrigatórios
                if(!empty($_POST['nome']) and !empty($_POST['email']) and !empty($_POST['senha']) and !empty($_POST['repete_senha'])){

                    // Validar se os valores são aceitos
                    if (!preg_match("/^[a-zA-Z-' ]*$/",$_POST['nome'])) {
                        $erros['erro_nome'] = "Informe apenas letras e espaço em branco!";
                    }
                    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                        $erros['erro_email'] = "Formato de email inválido!";
                    }
                    if($_POST['senha'] != $_POST['repete_senha']){
                        $erros['erro_senha'] = "As senhas não batem!";
                    }else{
                        // Verifica o tamanho da senha
                        if(!strlen($_POST['senha']) >= 6){
                            $erros['erro_senha'] = "A senha deve ter no mínimo 6 caracteres!";
                        }
                    }


                    // Verificar os outros campos que não são obrigatórios
                    if(!empty($_POST['whatsapp'])){
                        if(!strlen($_POST['whatsapp']) == 11){
                            $erros['erro_whatsapp'] = "Whatsapp inválido!";
                        }
                    }
                    if(!empty($_POST['instagram'])){
                        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$_POST['instagram'])) {
                            $erros['erro_instagram'] = "Link de url do instagram inválida!";
                        }
                    }
                    if(!empty($_POST['twitter'])){
                        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$_POST['twitter'])) {
                            $erros['erro_twitter'] = "Link de url do twitter inválida!";
                        }
                    }
                    if(!empty($_POST['facebook'])){
                        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$_POST['facebook'])) {
                            $erros['erro_facebook'] = "Link de url do facebook inválida!";
                        }
                    }
                    if(!empty($_POST['youtube'])){
                        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$_POST['youtube'])) {
                            $erros['erro_youtube'] = "Link de url do youtube inválida!";
                        }
                    }
      
                
                }else{
                    // Emitir mensagem que há campos obrigatorios que n foram preenchidos
                    $erros['erro_campos'] = 'Há campos obrigatórios que não foram preenchidos!';
                }

            }else{
                // Houve um problema ao enviar o formulário
                $erros['erro_formulario'] = 'Houve um problema ao enviar o formulário!';
            }

            if(empty($erros)){
                // Esta vazio, então não tem erros
                $usuarioEntidade = new UsuarioEntidade();
                $usuarioEntidade->setNome($_POST['nome']);
                $usuarioEntidade->setEmail($_POST['email']);
                $usuarioEntidade->setNome($_POST['nome']);
                $usuarioEntidade->setWhatsapp($_POST['whatsapp']);
                $usuarioEntidade->setInstagram($_POST['instagram']);
                $usuarioEntidade->setFacebook($_POST['facebook']);
                $usuarioEntidade->setTwitter($_POST['twitter']);
                $usuarioEntidade->setYoutube($_POST['youtube']);
                $usuarioEntidade->setSobre($_POST['sobre']);
                $usuarioEntidade->setSenha($_POST['senha']);
                
                $postModel = new PostModel();

            }else{
                // Há erros
            }

        }else{
            // não existe sessão
            $this->index();
        }
    }

    public function configuracoes(){
        session_start();
        if((isset($_SESSION['token']) and !empty($_SESSION['token'])) and (isset($_SESSION['id_usuario']) and !empty($_SESSION['id_usuario']))){
            $this->carregarTemplate("configuracoes",array());
        }else{
            $this->index();
        }
    }

    public function novopost(){
        session_start();
        if((isset($_SESSION['token']) and !empty($_SESSION['token'])) and (isset($_SESSION['id_usuario']) and !empty($_SESSION['id_usuario']))){
            $postModel = new PostModel();
            $categorias = $postModel->listarCategorias();
            $this->carregarTemplate("novopost",array($categorias,""));
        }else{
            $this->index();
        }
    }

    public function cadastrar(){
        session_start();
        if((isset($_SESSION['token']) and !empty($_SESSION['token'])) and (isset($_SESSION['id_usuario']) and !empty($_SESSION['id_usuario']))){
            if((isset($_POST['titulo']) and !empty($_POST['titulo'])) and (isset($_POST['conteudo']) and !empty($_POST['conteudo'])) and (isset($_POST['categoria']) and !empty($_POST['categoria']))){
               
                $titulo = $this->limparEntradaDeDados($_POST['titulo']);
                $conteudo = filter_input(INPUT_POST,'conteudo',FILTER_SANITIZE_SPECIAL_CHARS);
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
                $categorias = $postModel->listarCategorias();
    
                $this->carregarTemplate("novopost",array($categorias,$resultado));
                
            }else{
                $aviso = "Por favor, preencha todos os campos!";
                $postModel = new PostModel();
                $categorias = $postModel->listarCategorias();
                $this->carregarTemplate("novopost",array($categorias,$aviso));
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
                $categorias = $postModel->listarCategorias();
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
                
                $postEntidade = new PostEntidade();
                $postEntidade->setIdPostagem($id_postagem);
                $postEntidade->setTitulo($titulo);
                $postEntidade->setFkIdCategoria($fk_id_categoria);
                $postEntidade->setConteudo($conteudo);
    
                $postModel = new PostModel();
                $resposta = $postModel->atualizar($postEntidade);

                $postagem = $postModel->buscarPostPorId($id_postagem);
                $categorias = $postModel->listarCategorias();
                $this->carregarTemplate("editarpost",array($postagem,$categorias,$resposta));

            }else{
                // Preencher todos os dados
                $id_postagem = $this->limparEntradaDeDados($_POST['id_postagem']);
                $postModel = new PostModel();
                $postagem = $postModel->buscarPostPorId($id_postagem);
                $categorias = $postModel->listarCategorias();
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