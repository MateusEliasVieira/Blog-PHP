<?php

class UsuarioEntidade{

    private int $id_usuario;
    private string $nome;
    private string $email;
    private string $whatsapp;
    private string $instagram;
    private string $facebook;
    private string $twitter;
    private string $youtube;
    private string $sobre;
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

    public function setWhatsapp(string $whatsapp){
        $this->whatsapp = $whatsapp;
    }
    public function getWhatsapp(){
        return $this->whatsapp;
    }

    public function setInstagram(string $instagram){
        $this->instagram = $instagram;
    }
    public function getInstagram(){
        return $this->instagram;
    }

    public function setFacebook(string $facebook){
        $this->facebook = $facebook;
    }
    public function getFacebook(){
        return $this->facebook;
    }

    public function setTwitter(string $twitter){
        $this->twitter = $twitter;
    }
    public function getTwitter(){
        return $this->twitter;
    }

    public function setYoutube(string $youtube){
        $this->youtube = $youtube;
    }
    public function getYoutube(){
        return $this->youtube;
    }

    public function setSobre(string $sobre){
        $this->sobre = $sobre;
    }
    public function getSobre(){
        return $this->sobre;
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