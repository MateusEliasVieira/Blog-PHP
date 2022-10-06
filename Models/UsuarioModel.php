<?php

require_once "lib/database/Conexao.php";

class UsuarioModel{

    private $con;
    private $erro_upload = array();

    public function __construct(){
        $this->erro_upload = array();
        $this->con = Conexao::getConnection();
    }

    // =========================== Informações  ===========================


    public function mostrarInformacoesDoBlog(){

    }

    // =========================== Postagem  ===========================

    public function cadastrarNovaPostagem(PostEntidade $post){
        $postModel = new PostModel();
        $postModel->cadastrar($post);
    }

    public function listarMinhasPostagens(){
        $postModel = new PostModel();
        $postModel->meusposts($_SESSION['id_postagem']);
    }

    public function atualizarPostagem(PostEntidade $post){
        $postModel = new PostModel();
        $postModel->atualizar($post);
    }

    public function deletarPostagem(){

    }


    // =========================== Usuário  ===========================

    public function cadastrarNovoUsuarioAdm(){

    }

    public function buscarMeusDados(){
        try{
            $sql = "SELECT * FROM usuario_adm WHERE id_usuario = :id_usuario";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(":id_usuario",$_SESSION['id_usuario']);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            die('Erro ao buscar dados do usuário administrador logado!');
        }
    }

    public function listarUsuariosAdm(){

    }

    public function atualizarDadosDoPerfil(UsuarioEntidade $usuarioEntidade){

        $nome = $usuarioEntidade->getNome();
        $email = $usuarioEntidade->getEmail();
        $whatsapp = $usuarioEntidade->getWhatsapp();
        $instagram = $usuarioEntidade->getInstagram();
        $facebook = $usuarioEntidade->getFacebook();
        $twitter = $usuarioEntidade->getTwitter();
        $youtube = $usuarioEntidade->getYoutube();
        $sobre = $usuarioEntidade->getSobre();
        $senha = $usuarioEntidade->getSenha();
        $caminho_imagem = $this->uploadImagem();
        
        try{
            $sql = "UPDATE usuario_adm SET nome = :nome, email = :email, whatsapp = :whatsapp, instagram = :instagram, facebook = :facebook, twitter = :twitter, youtube = :youtube, sobre = :sobre, senha = :senha, caminho_imagem = :caminho_imagem WHERE id_usuario = :id_usuario"; 
            
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':nome',$nome);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':whatsapp',$whatsapp);
            $stmt->bindParam(':instagram',$instagram);
            $stmt->bindParam(':facebook',$facebook);
            $stmt->bindParam(':twitter',$twitter);
            $stmt->bindParam(':youtube',$youtube);
            $stmt->bindParam(':sobre',$sobre); 
            $senha_criptografada = sha1($senha);
            $stmt->bindParam(':senha',$senha_criptografada); 
            $stmt->bindParam(':caminho_imagem',$caminho_imagem);
            $stmt->bindParam(':id_usuario',$_SESSION['id_usuario']);
            
            return $stmt->execute(); 
        }catch(Exception $e){
            die('Erro ao atualizar dados do usuário administrador!');
        }
    }


    public function qtd_usuario(){
        try{
            $sql = "SELECT COUNT(id_usuario) AS qtd_usuario FROM usuario_adm";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            extract($stmt->fetch(PDO::FETCH_ASSOC));
            return $qtd_usuario;
        }catch(Exception $e){
            die("Erro ao buscar quantidade de usuário na base de dados!");
        }
    }

    private function uploadImagem(){

        if(isset($_FILES['arquivo']) and !empty($_FILES['arquivo']['name'])){
            $caminho_upload_imagem = "midia/uploads";
            $formatos_permitidos = array("jpg", "jpeg", "png");
            $tamanho_imagem_permitido = 26214400;

            $nome_imagem = $_FILES['arquivo']['name'];
            $formato_imagem = explode(".",$nome_imagem)[1];
            $tamanho_imagem = $_FILES['arquivo']['size'];

            $upload = $caminho_upload_imagem."/".$nome_imagem;

            if(is_dir($caminho_upload_imagem)){
                // É um diretório

                if(in_array($formato_imagem,$formatos_permitidos)){
                    // Formato permitido
                    if($tamanho_imagem < $tamanho_imagem_permitido){
                        // Tamanho OK
                        $resultado = move_uploaded_file($_FILES['arquivo']['tmp_name'],$upload);
                        if($resultado){
                            // Deu certo para fazer upload
                            // unset($_FILES['imagem']);
                            return $upload;
                        }else{
                            // Deu erro para fazer upload
                            return "";
                        }
    
                    }else{
                        // Muito grande a imagem
                        $this->erro_upload['erro_tamanho'] = "Tamanho da imagem é muito grande! Máximo(25Mb)";
                        return "";
                    }
                }else{
                    // Formato não permitido
                    $this->erro_upload['erro_formato'] = "Formato de arquivo inválido! Permitido apenas (jpg, jpeg e png).";
                    return "";
                }
            }else{
                // Não existe o diretório
                $this->erro_upload['erro_diretorio'] = "Não existe o caminho para fazer o upload!";
                return "";
            }
        }else{
            return "";
        }

    }
    

}