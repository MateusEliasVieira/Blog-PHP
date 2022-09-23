<?php

class UsuarioEntidade{

    private int $id_usuario;
    private string $nome;
    private string $email;
    private string $senha;
    private string $token;
    private string $caminho_imagem;

    public function getIdUsuario(){
        return $this->id_usuario;
    }

    public function setIdUsuario(int $id_usuario){
        $this->id_usuario = $id_usuario;
    }

    public function getNome(){
        return $this->nome;
    }

    public function setNome(string $nome){
        $this->nome = $nome;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail(string $email){
        $this->email = $email;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function setSenha(string $senha){
        $this->senha = $senha;
    }

    public function getToken(){
        return $this->token;
    }

    public function setToken(string $token){
        $this->token = $token;
    }

    public function getCaminhoImagem(){
        return $this->caminho_imagem;
    }

    public function setCaminhoImagem(string $caminho_imagem){
        $this->caminho_imagem = $caminho_imagem;
    }



}