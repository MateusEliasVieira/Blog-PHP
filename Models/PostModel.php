<?php 

require_once "Conexao.php";

class PostModel{

    private $con;
    private $erro_upload = array();

    public function __construct(){
        $this->erro_upload = array();
        $this->con = Conexao::getConnection();
    }

    // Realiza upload de imagem
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

    // Cadastra uma nova postagem
    public function cadastrar(PostEntidade $post){   
        $titulo = $post->getTitulo();
        $conteudo = $post->getConteudo();
        $data_postagem = $post->getDataPostagem();
        $curtidas = $post->getCurtidas();
        $quantidade_comentarios = $post->getQuantidadeComentarios();
        $fk_id_usuario = $post->getFkIdUsuario();
        $fk_id_categoria = $post->getFkIdCategoria();
        try{
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
        }catch(Exception $e){
            die("Erro ao cadastrar nova postagem!");
        }
    }

    // Atualiza uma postagem
    public function atualizar(PostEntidade $post){
        $id_postagem = $post->getIdPostagem();
        $titulo = $post->getTitulo();
        $conteudo = $post->getConteudo();
        $fk_id_categoria = $post->getFkIdCategoria();
        try{
            if(empty($this->erro_upload)){

                $stmt = $this->con->prepare("UPDATE postagem SET titulo = :titulo, conteudo = :conteudo, fk_id_categoria = :fk_id_categoria WHERE id_postagem = :id_postagem");
                $stmt->bindParam(':titulo',$titulo);
                $stmt->bindParam(':conteudo',$conteudo);
                $stmt->bindParam(':fk_id_categoria',$fk_id_categoria);
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

    // Lista todas as postagens por data mais recente
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

    // Busca uma única postagem através de seu id
    public function buscarPostPorId(int $id_postagem){
        try{
            $sql = "SELECT * FROM postagem WHERE id_postagem = :id_postagem LIMIT 1";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':id_postagem',$id_postagem);
            $stmt->execute();
            $post = $stmt->fetch(PDO::FETCH_ASSOC);
            return $post;
        }catch(Exception $e){
            die("Erro ao buscar postagem por id na base de dados!");
        }
    }

    // Busca uma única postagem através de seu título
    public function buscarPostPorTitulo(string $titulo){
        try{
            $sql = "SELECT * FROM postagem WHERE titulo = :titulo LIMIT 1";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':titulo',$titulo);
            $stmt->execute();
            $post = $stmt->fetch(PDO::FETCH_ASSOC);
            return $post;
        }catch(Exception $e){
            die("Erro ao buscar postagem por titulo na base de dados!");
        }
    }

    // Lista as postagens do usuário que esta ativo na sessão
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

    // Lista todos so usuários e suas postagens 
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
    
    public function listarUsuarioPostagensDaCategoria(string $categoria){
        try{
            $sql = "SELECT U.nome,P.titulo,P.conteudo,P.curtidas,P.quantidade_comentarios,P.data_postagem 
            FROM usuario_adm AS U 
            INNER JOIN postagem AS P 
            ON U.id_usuario = P.fk_id_usuario 
            INNER JOIN categoria AS C 
            ON P.fk_id_categoria = C.id_categoria 
            WHERE C.nome_categoria = :categoria";

            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(":categoria",$categoria);
            $stmt->execute();
            $usuario_postagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuario_postagens;

        }catch(Exception $e){

        }
    }

    // Busca todas as categorias
    public function listarCategorias(){
        try{
            $sql = "SELECT * FROM categoria";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            $post = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $post;
        }catch(Exception $e){
            die("Erro ao buscar categorias na base de dados!");
        }
    }

    // Busca as postagens em destaque, isto é, as três primeiras mais recentes
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

    // Busca uma postagem e seus comentários
    public function buscarPostComentarios(string $titulo){
        // echo "<h1 style='position:fixed; z-index:20;'>".$titulo."</h1>";
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

    // Curtir uma postagem
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

    // Comentar uma postagem
    public function comentar(ComentarioEntidade $comentario){
        try{
            $sql = "INSERT INTO comentario(nome,mensagem,data_comentario,fk_id_postagem) VALUES(:nome,:mensagem,:data_comentario,:fk_id_postagem)";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':nome',$comentario->getNome());
            $stmt->bindValue(':mensagem',$comentario->getMensagem());
            $stmt->bindValue(':data_comentario',$comentario->getDataComentario());
            $stmt->bindValue(':fk_id_postagem',$comentario->getFkIdPostagem());
            $resultado = $stmt->execute();
            if($resultado){
                $sql = "SELECT quantidade_comentarios FROM postagem WHERE id_postagem = :id_postagem";
                $stmt = $this->con->prepare($sql);
                $stmt->bindValue(':id_postagem',$comentario->getFkIdPostagem());
                $stmt->execute();
                extract($stmt->fetch(PDO::FETCH_ASSOC));
                $quantidade_comentarios += 1;

                $sql = "UPDATE postagem SET quantidade_comentarios = :quantidade_comentarios WHERE id_postagem = :id_postagem";
                $stmt = $this->con->prepare($sql);
                $stmt->bindValue(':quantidade_comentarios',$quantidade_comentarios);
                $stmt->bindValue(':id_postagem',$comentario->getFkIdPostagem());
                $resultado = $stmt->execute();
                return $resultado;
            }else{
                return $resultado;
            }
        }catch(Exception $e){
            die("Erro ao comentar sobre o post");
        }
    }

}