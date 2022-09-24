<?php 

require_once "Conexao.php";

class PostModel{

    private $con;
    private $erro_upload = array();

    public function __construct(){
        $this->erro_upload = array();
        $this->con = Conexao::getConnection();
    }

    private function uploadImagem(){

        if(isset($_FILES['imagem']) and !empty($_FILES['imagem'])){
            
            $caminho_upload_imagem = "midia/uploads";
            $formatos_permitidos = array("jpg", "jpeg", "png");
            $tamanho_imagem_permitido = 26214400;

            $nome_imagem = $_FILES['imagem']['name'];
            $formato_imagem = explode(".",$nome_imagem)[1];
            $tamanho_imagem = $_FILES['imagem']['size'];

            $upload = $caminho_upload_imagem."/".$nome_imagem;

            if(is_dir($caminho_upload_imagem)){
                // É um diretório

                if(in_array($formato_imagem,$formatos_permitidos)){
                    // Formato permitido
                    if($tamanho_imagem < $tamanho_imagem_permitido){
                        // Tamanho OK
                        $resultado = move_uploaded_file($_FILES['imagem']['tmp_name'],$upload);
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

    public function cadastrar(PostEntidade $post){
     
        $titulo = $post->getTitulo();
        $conteudo = $post->getConteudo();
        $data_postagem = $post->getDataPostagem();
        $curtidas = $post->getCurtidas();
        $quantidade_comentarios = $post->getQuantidadeComentarios();
        $fk_id_usuario = $post->getFkIdUsuario();
        $fk_id_categoria = $post->getFkIdCategoria();

        unset($_FILES);

        try{
            if(empty($this->erro_upload)){
                $stmt = $this->con->prepare("INSERT INTO postagem(titulo,conteudo,data_postagem,curtidas,quantidade_comentarios,fk_id_usuario,fk_id_categoria) VALUES(:titulo,:conteudo,:data_postagem,:curtidas,:quantidade_comentarios,:fk_id_usuario,:fk_id_categoria)");
                $stmt->bindParam(':titulo',$titulo);
                $stmt->bindParam(':conteudo',$conteudo);
                $stmt->bindParam(':data_postagem',$data_postagem);
                $stmt->bindParam(':curtidas',$curtidas);
                $stmt->bindParam(':quantidade_comentarios',$quantidade_comentarios);
                $stmt->bindParam(':fk_id_usuario',$fk_id_usuario);
                $stmt->bindParam(':fk_id_categoria',$fk_id_categoria);
                
                unset($_POST);

                return $stmt->execute();
            }else{
                return $this->erro_upload;
            }
        }catch(Exception $e){
            echo "Erro = ".$e->getMessage();
            die("Erro ao cadastrar nova postagem!");
        }
    }

    public function atualizar(PostEntidade $post){
     
        $id_postagem = $post->getIdPostagem();
        $titulo = $post->getTitulo();
        $conteudo = $post->getConteudo();

        $caminho_post = "";
        $caminho_post = $this->uploadImagem();

        unset($_FILES);

        try{
            if(empty($this->erro_upload)){

                $stmt = $this->con->prepare("UPDATE postagem SET titulo = :titulo, conteudo = :conteudo, imagem_post = :imagem_post WHERE id_postagem = :id_postagem");
                $stmt->bindParam(':titulo',$titulo);
                $stmt->bindParam(':conteudo',$conteudo);
                $stmt->bindParam(':imagem_post',$caminho_post);
                $stmt->bindParam(':id_postagem',$id_postagem);

                unset($_POST);

                return $stmt->execute();
            }else{
                return $this->erro_upload;
            }
        }catch(Exception $e){
            die("Erro ao atualizar postagem!");
        }
        
    } 


    public function listarPostagens(){
        try{
            $sql = "SELECT * FROM postagem ORDER BY data_postagem DESC";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            $postagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $postagens;
        }catch(Exception $e){
            die("Erro ao buscar postagens na base de dados!");
        }
    }

    public function listarUsuarioPostagens(){
        try{
            $sql = "SELECT U.nome,P.titulo,P.conteudo,P.curtidas,P.quantidade_comentarios,P.data_postagem from usuario_adm as U inner join postagem as P on U.id_usuario = P.fk_id_usuario";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            $usuario_postagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuario_postagens;
        }catch(Exception $e){
            die("Erro ao buscar usuário e suas postagens na base de dados!");
        }
    }

    public function listarCategorias(){
        try{
            $sql = "SELECT * FROM categoria";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $categorias;
        }catch(Exception $e){
            die("Erro ao buscar categorias na base de dados!");
        }
    }

    public function listarDestaques(){
        try{
            $sql = "SELECT * FROM postagem ORDER BY data_postagem DESC LIMIT 3";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            $destaques = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $destaques;
        }catch(Exception $e){
            die("Erro ao buscar postagens em destaques na base de dados!");
        }
    }

    public function buscarPost(string $titulo){
        try{
            $sql = "SELECT * FROM postagem WHERE titulo = :titulo LIMIT 1";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':titulo',$titulo);
            $stmt->execute();
            $post = $stmt->fetch(PDO::FETCH_ASSOC);
            return $post;
        }catch(Exception $e){
            die("Erro ao buscar postagem na base de dados!");
        }
    }
    public function buscarPostComentarios(string $titulo){
        try{
            $sql = "SELECT * FROM postagem as p inner join comentario as c on p.id_postagem = c.fk_id_postagem WHERE p.titulo = :titulo";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':titulo',$titulo);
            $stmt->execute();
            // Caso exista, nessa variavel teremos uma matriz
            // cada posição será um vetor com os dados do postagem
            // portanto retornamos uma matriz 
            $post = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Se estiver vazio, significa que não há comentários para esse post
            // Por isso temos que buscar apenas a postagem sem comentário
            if(empty($post)){
                $sql = "SELECT * FROM postagem WHERE titulo = :titulo";
                $stmt = $this->con->prepare($sql);
                $stmt->bindValue(':titulo',$titulo);
                $stmt->execute();
                // Aqui é apenas um vetor onde as posições são as colunas da tabela
                $post = $stmt->fetch(PDO::FETCH_ASSOC);

                // Devemos devolver uma matriz pois a view espera uma matriz de dados e não um vetor
                // por isso criamos uma matriz de uma posição
                $matriz = array($post);
                return $matriz;
            }

            return $post;
        }catch(Exception $e){
            die("Erro ao buscar postagem e comentarios na base de dados!");
        }
    }

    public function curtir(int $id_postagem){
        try{
            $sql = "SELECT curtidas FROM postagem WHERE id_postagem = :id_postagem";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':id_postagem',$id_postagem);
            $stmt->execute();
            extract($stmt->fetch(PDO::FETCH_ASSOC));
            $curtidas += 1;
            $sql = "UPDATE postagem SET curtidas = :curtidas WHERE id_postagem = :id_postagem";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':curtidas',$curtidas);
            $stmt->bindValue(':id_postagem',$id_postagem);
            return $stmt->execute();   
        }catch(Exception $e){
            die("Erro ao curtir postagem!");
        }
    }

    public function meusposts($id_usuario){
        try{
            $sql = "SELECT P.id_postagem, P.titulo, P.conteudo , P.curtidas, P.quantidade_comentarios, P.data_postagem FROM postagem as P inner join usuario_adm as U on U.id_usuario = P.fk_id_usuario WHERE U.id_usuario = :id_usuario";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':id_usuario',$id_usuario);
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $posts;
        }catch(Exception $e){
            die("Erro ao buscar meus posts!");
        }
    }

}