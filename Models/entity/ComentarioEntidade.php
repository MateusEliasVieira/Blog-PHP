<?php

class ComentarioEntidade{

    private int $id_comentario;
    private string $nome;
    private string $mensagem;
    private $data_comentario;
    private int $fk_id_postagem;

    public function setIdComentario($id_comentario){
        $this->id_comentario = $id_comentario;
    }
    public function getIdComentario(){
        return $this->id_comentario;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }
    public function getNome(){
        return $this->nome;
    }

    public function setMensagem($mensagem){
        $this->mensagem = $mensagem;
    }
    public function getMensagem(){
        return $this->mensagem;
    }

    public function setDataComentario($data_comentario){
        $this->data_comentario = $data_comentario;
    }
    public function getDataComentario(){
        return $this->data_comentario;
    }

    public function setFkIdPostagem($fk_id_postagem){
        $this->fk_id_postagem = $fk_id_postagem;
    }
    public function getFkIdPostagem(){
        return $this->fk_id_postagem;
    }

}