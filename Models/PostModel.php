<?php 

require_once "lib/database/Conexao.php";

class PostModel{

    private $con;
    private $erro_upload = array();

    public function __construct(){
        $this->erro_upload = array();
        $this->con = Conexao::getConnection();
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
            $resposta = $stmt->execute(); 
            
            if($resposta){
                $stmt = $this->con->prepare("SELECT quantidade_postagens from categoria WHERE id_categoria = :id_categoria");
                $stmt->bindParam(':id_categoria',$fk_id_categoria);
                $stmt->execute();
                extract($stmt->fetch(PDO::FETCH_ASSOC));
                $quantidade_postagens += 1;

                $stmt = $this->con->prepare("UPDATE categoria SET quantidade_postagens = :quantidade_postagens WHERE id_categoria = :id_categoria");
                $stmt->bindParam(':quantidade_postagens',$quantidade_postagens);
                $stmt->bindParam(':id_categoria',$fk_id_categoria);
                $resposta = $stmt->execute();
            }

            return $resposta;
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

    // Deleta alguma postagem
    public function deletarPostagem($id_postagem){
        try{
            // Limpando $_POST
            unset($_POST);
            // Deletar os comentários primeiro
            $resultado = $this->deletarComentariosDaPostagem($id_postagem);
            if($resultado){

                // Decrementar a quantidade de postagens da categoria
                $sql = "SELECT fk_id_categoria FROM postagem WHERE id_postagem = :id_postagem";
                $stmt = $this->con->prepare($sql);
                $stmt->bindParam(':id_postagem',$id_postagem);
                $stmt->execute();
                extract($stmt->fetch(PDO::FETCH_ASSOC));

                $categoriaModel = new CategoriaModel();
                $resultado = $categoriaModel->atualizarQuantidadeDePostagensDaCategoria($fk_id_categoria);

                if($resultado){
                    // Deletar a postagem
                    $sql = "DELETE FROM postagem WHERE id_postagem = :id_postagem";
                    $stmt = $this->con->prepare($sql);
                    $stmt->bindParam(':id_postagem',$id_postagem);
                    $resultado = $stmt->execute();
                    return $resultado;
                }
            }
            return false;
        }catch(Exception $e){
            die("Não foi possível deletar a postagem!");
        }
    }

    // Deleta os comentários de uma postagem
    public function deletarComentariosDaPostagem($id_postagem){
        try{
            // Deletar comentarios primeiro
            $sql = "DELETE FROM comentario WHERE fk_id_postagem = :id_postagem";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':id_postagem',$id_postagem);
            return $stmt->execute();
        }catch(Exception $e){
            die("Não foi possível deletar a postagem!");
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

    // Mostra a quantidade de postagens existentes
    public function qtd_postagem(){
        try{
            $sql = "SELECT SUM(quantidade_postagens) AS qtd_postagem FROM categoria";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            extract($stmt->fetch(PDO::FETCH_ASSOC));
            return $qtd_postagem;
        }catch(Exception $e){
            die("Erro ao buscar quantidade de postagem na base de dados!");
        }
    }

    // Mostra a quantidade de postagens existentes
    public function qtdPostagemUsuario($nome){
        try{
            $sql = "SELECT count(fk_id_usuario) AS qtd_postagem 
            FROM postagem AS P 
            INNER JOIN usuario_adm AS U 
            ON p.fk_id_usuario = U.id_usuario
            WHERE U.nome = :nome";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(":nome",$nome);
            $stmt->execute();
            extract($stmt->fetch(PDO::FETCH_ASSOC));
            return $qtd_postagem;
        }catch(Exception $e){
            die("Erro ao buscar quantidade de postagens do usuário na base de dados!");
        }
    }

    // Lista as postagens do usuário que esta ativo na sessão
    public function meusposts($id_usuario){
        try{
            $sql = "SELECT P.id_postagem, P.titulo, P.conteudo , P.curtidas, P.visualizacoes, P.quantidade_comentarios, P.data_postagem FROM postagem as P inner join usuario_adm as U on U.id_usuario = P.fk_id_usuario WHERE U.id_usuario = :id_usuario ORDER BY P.data_postagem DESC";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':id_usuario',$id_usuario);
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $posts;
        }catch(Exception $e){
            die("Erro ao buscar meus posts!");
        }
    }

    // Lista todos os usuários e suas postagens 
    public function listarUsuarioPostagens(){
        try{
            $sql = "SELECT U.nome,P.titulo,P.curtidas,P.visualizacoes,P.quantidade_comentarios,P.data_postagem from usuario_adm as U inner join postagem as P on U.id_usuario = P.fk_id_usuario ORDER BY P.data_postagem DESC";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            $usuario_postagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuario_postagens;
        }catch(Exception $e){
            die("Erro ao buscar usuário e suas postagens na base de dados!");
        }
    }
    
    // Lista usuários e suas postagens pela categoria da postagem
    public function listarUsuarioPostagensDaCategoria(string $categoria){
        try{
            $sql = "SELECT U.nome,P.titulo,P.conteudo,P.curtidas,P.visualizacoes,P.quantidade_comentarios,P.data_postagem 
            FROM usuario_adm AS U 
            INNER JOIN postagem AS P 
            ON U.id_usuario = P.fk_id_usuario 
            INNER JOIN categoria AS C 
            ON P.fk_id_categoria = C.id_categoria 
            WHERE C.nome_categoria = :categoria
            ORDER BY P.data_postagem DESC";

            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(":categoria",$categoria);
            $stmt->execute();
            $usuario_postagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuario_postagens;
        }catch(Exception $e){

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
            $resultado = $stmt->execute(); 
            if($resultado){
                setcookie($id_postagem,true,time()+(86400 * 30));
            }  
            return $resultado;
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

    // Busca a quantidade de visualizações total das postagens de um autor
    public function buscarQuantidadeDeVisualizacoes($nome_autor){
        try{
            $sql = "SELECT sum(visualizacoes) as visualizacoes
            FROM postagem as P
            inner join usuario_adm as U 
            on P.fk_id_usuario = U.id_usuario
            where U.nome = :nome_autor";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':nome_autor',$nome_autor);
            $stmt->execute();
            extract($stmt->fetch(PDO::FETCH_ASSOC));
            return $visualizacoes;
        }catch(Exception $e){
            die("Erro ao buscar quantidade de visualizações!");
        }
    }

    // Atualiza as visualições de uma postagem ao entrar nela
    public function atualizarVisualizacoes($titulo){
        try{
            $sql = "SELECT visualizacoes FROM postagem WHERE titulo = :titulo";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':titulo',$titulo);
            $stmt->execute();
            extract($stmt->fetch(PDO::FETCH_ASSOC));
            $visualizacoes += 1;
            $sql = "UPDATE postagem SET visualizacoes = :visualizacoes WHERE titulo = :titulo";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':visualizacoes',$visualizacoes);
            $stmt->bindValue(':titulo',$titulo);
            $stmt->execute();
        }catch(Exception $e){
            die("Erro ao atualizar visualizações");
        }
    }


}