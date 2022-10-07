<?php

require_once "lib/database/Conexao.php";

class CategoriaModel{

    private $con;

    public function __construct(){
        $this->con = Conexao::getConnection();
    }

    // cadastra uma nova categoria
    public function cadastrarNovaCategoria(){

    }

    // lista todas as categorias
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

    // atualiza alguma categoria existente
    public function atualizarCategoria(){

    }

    // deleta uma categoria e suas respectivas postagens
    public function deletarCategoriaESuasPostagens(){

    }

    // mostra a quantidade de categorias existentes
    public function qtd_categoria(){
        try{
            $sql = "SELECT COUNT(id_categoria) AS qtd_categoria FROM categoria";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            extract($stmt->fetch(PDO::FETCH_ASSOC));
            return $qtd_categoria;
        }catch(Exception $e){
            die("Erro ao buscar quantidade de categoria na base de dados!");
        }
    }

    public function atualizarQuantidadeDePostagensDaCategoria($id_categoria){
        try{
            $sql = "SELECT quantidade_postagens FROM categoria WHERE id_categoria = :id_categoria";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':id_categoria',$id_categoria);
            $stmt->execute();
            extract($stmt->fetch(PDO::FETCH_ASSOC));
            $quantidade_postagens -= 1;

            $sql = "UPDATE categoria SET quantidade_postagens = :quantidade_postagens WHERE id_categoria = :id_categoria";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':quantidade_postagens',$quantidade_postagens);
            $stmt->bindParam(':id_categoria',$id_categoria);
            return $stmt->execute();
        }catch(Exception $e){
            die("Erro ao buscar quantidade de categoria na base de dados!");
        }
    }

    
}

