<?php

class InscritoEntidade{

    private int $id_inscrito;
    private string $email;
    private $data_inscricao;
    private $permissao;

    public function getIdInscrito(){
        return $this->id_inscrito;
    }
    public function setIdInscrito(int $id_inscrito){
        $this->id_inscrito = $id_inscrito;
    }

    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }

    public function getDataInscricao(){
        return $this->data_inscricao;
    }
    public function setDataInscricao($data_inscricao){
        $this->data_inscricao = $data_inscricao;
    }

    public function getPermissao(){
        return $this->permissao;
    }
    public function setPermissao($permissao){
        $this->permissao = $permissao;
    }

}