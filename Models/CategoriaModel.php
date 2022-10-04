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

    
}

