<?php

class PostEntidade{
    
    private int $id_postagem;
    private string $titulo;
    private string $conteudo;
    private $data_postagem;
    private int $curtidas;
    private string $imagem_post;
    private int $fk_id_usuario;

    public function setIdPostagem($id_postagem){
        $this->id_postagem = $id_postagem;
    }
    public function getIdPostagem(){
        return $this->id_postagem;
    }

    public function setTitulo($titulo){
        $this->titulo = $titulo;
    }
    public function getTitulo(){
        return $this->titulo;
    }

    public function setConteudo($conteudo){
        $this->conteudo = $conteudo;
    }
    public function getConteudo(){
        return $this->conteudo;
    }

    public function setDataPostagem($data_postagem){
        $this->data_postagem = $data_postagem;
    }
    public function getDataPostagem(){
        return $this->data_postagem;
    }

    public function setCurtidas(int $curtidas){
        $this->curtidas = $curtidas;
    }
    public function getCurtidas(){
        return $this->curtidas;
    }

    public function setImagemPost($imagem_post){
        $this->imagem_post = $imagem_post;
    }
    public function getImagemPost(){
        return $this->imagem_post;
    }

    public function setFkIdUsuario($fk_id_usuario){
        $this->fk_id_usuario = $fk_id_usuario;
    }
    public function getFkIdUsuario(){
        return $this->fk_id_usuario;
    }
    
}