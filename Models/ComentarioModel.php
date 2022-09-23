<?php

class ComentarioModel{

    private $con;

    public function __construct(){
        $this->con = Conexao::getConnection();
    }

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