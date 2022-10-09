<?php

session_start();

class UsuarioController extends Controller{

    public function index(){
        $postController = new PostController();
        $postController->index();
    }

    // Método para carregar a view de informações do blog (postagens,categorias...)
    public function administrador(){
        
        if((isset($_SESSION['token']) and !empty($_SESSION['token'])) and (isset($_SESSION['id_usuario']) and !empty($_SESSION['id_usuario']))){
            $usuarioModel = new UsuarioModel();
            $postModel = new PostModel();
            $categoriaModel = new CategoriaModel();

            $qtd_usuario = $usuarioModel->qtd_usuario();
            $qtd_categoria = $categoriaModel->qtd_categoria();
            $qtd_postagem = $postModel->qtd_postagem();  

            $this->carregarTemplate("administrador",array($qtd_usuario,$qtd_categoria,$qtd_postagem));
        }else{
            $this->index();
        }
    }

    // Método para carregar a view para atualizar os dados de perfil do usuario
    public function configuracoes(){
        if((isset($_SESSION['token']) and !empty($_SESSION['token'])) and (isset($_SESSION['id_usuario']) and !empty($_SESSION['id_usuario']))){
            $this->carregarTemplate("configuracoes",array());
        }else{
            $this->index();
        }
    }

    // Método para carregar a view para cadastrar uma nova postagem
    public function novopost(){
        if((isset($_SESSION['token']) and !empty($_SESSION['token'])) and (isset($_SESSION['id_usuario']) and !empty($_SESSION['id_usuario']))){
            $categoriaModel = new CategoriaModel();
            $categorias = $categoriaModel->listarCategorias();
            $this->carregarTemplate("novopost",array($categorias,""));
        }else{
            $this->index();
        }
    }

    // Método para carregar a tela de posts já feitos pelo usuário
    public function meusposts(){
        if((isset($_SESSION['token']) and !empty($_SESSION['token'])) and (isset($_SESSION['id_usuario']) and !empty($_SESSION['id_usuario']))){
               
            $id_usuario = $this->limparEntradaDeDados($_SESSION['id_usuario']); 
            $postModel = new PostModel();
            $posts = $postModel->meusposts($id_usuario);
            $this->carregarTemplate("meusposts",array($posts,null));
    
        }else{
            $this->index();
        }
    
    }

    // Método para carregar a view de editar uma postagem
    public function editar(){
        if((isset($_SESSION['token']) and !empty($_SESSION['token'])) and (isset($_SESSION['id_usuario']) and !empty($_SESSION['id_usuario']))){
            if(isset($_POST["id_postagem"]) and !empty($_POST["id_postagem"])){
                $id_postagem = $this->limparEntradaDeDados($_POST["id_postagem"]);
                $postModel = new PostModel();
                $categoriaModel = new CategoriaModel();
                $postagem = $postModel->buscarPostPorId($id_postagem);
                $categorias = $categoriaModel->listarCategorias();
                $this->carregarTemplate("editarpost",array($postagem,$categorias,""));
            }
        }else{
            $this->index();
        }
    }

    public function excluir(){
        if((isset($_SESSION['token']) and !empty($_SESSION['token'])) and (isset($_SESSION['id_usuario']) and !empty($_SESSION['id_usuario']))){
            if(isset($_POST["id_postagem"]) and !empty($_POST["id_postagem"])){
                $id_postagem = $this->limparEntradaDeDados($_POST["id_postagem"]);
               
                $usuarioModel = new UsuarioModel();
                $resultado = $usuarioModel->deletarPostagem($id_postagem);
                
                $id_usuario = $this->limparEntradaDeDados($_SESSION['id_usuario']); 
                $postModel = new PostModel();
                $posts = $postModel->meusposts($id_usuario);
                $this->carregarTemplate("meusposts",array($posts,$resultado));
            }
        }else{
            $this->index();
        }
    }

    // Método para cadastrar uma nova postagem
    public function cadastrar(){
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
                $categoriaModel = new CategoriaModel();
                $resultado = $postModel->cadastrar($postEntidade);
                $categorias = $categoriaModel->listarCategorias();
    
                $this->carregarTemplate("novopost",array($categorias,$resultado));
                
            }else{
                $aviso = "Por favor, preencha todos os campos!";
                $categoriaModel = new CategoriaModel();

                $categorias = $categoriaModel->listarCategorias();
                $this->carregarTemplate("novopost",array($categorias,$aviso));
            }
        }else{
            $this->index();
        }
    }

    // Método para atualizar os dados de uma postagem que algum usuario adm fez
    public function atualizar(){
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
                $categoriaModel = new CategoriaModel();

                $resposta = $postModel->atualizar($postEntidade);

                $postagem = $postModel->buscarPostPorId($id_postagem);
                $categorias = $categoriaModel->listarCategorias();
                $this->carregarTemplate("editarpost",array($postagem,$categorias,$resposta));

            }else{
                // Preencher todos os dados
                $id_postagem = $this->limparEntradaDeDados($_POST['id_postagem']);
                $postModel = new PostModel();
                $categoriaModel = new CategoriaModel();

                $postagem = $postModel->buscarPostPorId($id_postagem);
                $categorias = $categoriaModel->listarCategorias();
                $resposta = "Preencha todos os dados!";
                $this->carregarTemplate("editarpost",array($postagem,$categorias,$resposta));
            }
        }else{
            $this->index();
        }
    }

    // Método para atualizar os dados do usuario adm
    public function usuario(){        
        $erros = array();

        if((isset($_SESSION['token']) and !empty($_SESSION['token'])) and (isset($_SESSION['id_usuario']) and !empty($_SESSION['id_usuario']))){
           
            // Verificar se existem os campos vindos do formulário
            if(isset($_POST['submit_atualizar']) and isset($_POST['nome']) and isset($_POST['email']) and isset($_POST['whatsapp']) and isset($_POST['instagram']) and isset($_POST['twitter']) and isset($_POST['facebook']) and isset($_POST['youtube']) and isset($_POST['senha']) and isset($_POST['repete_senha']) and isset($_POST['sobre'])){
                
                // Campos obrigatórios
                if(!empty($_POST['nome']) and !empty($_POST['email']) and !empty($_POST['senha']) and !empty($_POST['repete_senha'])){

                    // Validar se os valores são aceitos
                    if (!preg_match("/^[a-zA-Z-' ]*$/",$_POST['nome'])) {
                        $erros['erro_nome'] = "Nome inválido, informe apenas letras e espaço em branco!";
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
                        if(strlen($_POST['whatsapp']) < 11){
                            $erros['erro_whatsapp'] = "Whatsapp inválido! Necessário ter 11 dígitos";
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
                $erros['erro_formulario'] = 'Você não preencheu o formulário de atualização!';
            }

            if(empty($erros)){
                // Esta vazio, então não tem erros
                $usuarioEntidade = new UsuarioEntidade();
                $usuarioEntidade->setNome($_POST['nome']);
                $usuarioEntidade->setEmail($_POST['email']);
                $usuarioEntidade->setWhatsapp($_POST['whatsapp']);
                $usuarioEntidade->setInstagram($_POST['instagram']);
                $usuarioEntidade->setFacebook($_POST['facebook']);
                $usuarioEntidade->setTwitter($_POST['twitter']);
                $usuarioEntidade->setYoutube($_POST['youtube']);
                $usuarioEntidade->setSobre($_POST['sobre']);
                $usuarioEntidade->setSenha($_POST['senha']);
                
                $usuarioModel = new UsuarioModel();
                $resultado = $usuarioModel->atualizarDadosDoPerfil($usuarioEntidade);
                $this->carregarTemplate("configuracoes",$resultado);

            }else{
                // Há erros
                $this->carregarTemplate("configuracoes",$erros);
            }

        }else{
            // não existe sessão
            $this->index();
        }
    }
    
}