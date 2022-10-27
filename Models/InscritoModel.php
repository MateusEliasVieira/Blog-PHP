<?php

require_once "lib/database/Conexao.php";

class InscritoModel{

    private $conexao;

    public function __construct(){
        $this->conexao = Conexao::getConnection();
    }

    public function inscrever(InscritoEntidade $inscritoEntidade) {
        try{

            if($this->verificarEmail($inscritoEntidade->getEmail())){
                // Pode inserir novo email
                $sql = "INSERT INTO inscrito(email,data_inscricao,permissao) VALUES(:email,:data_inscricao,:permissao)";
                $stmt = $this->conexao->prepare($sql);
                $stmt->bindValue(':email',$inscritoEntidade->getEmail());
                $stmt->bindValue(':data_inscricao',$inscritoEntidade->getDataInscricao());
                $stmt->bindValue(':permissao',$inscritoEntidade->getPermissao());
                return $stmt->execute();
            }else{
                // Já existe esse email
                return false;
            }
        }catch(Exception $e){
            die("Ocorreu um erro ao realizar sua inscrição");
        }
    }

    public function verificarEmail(string $email){
        try{
            $sql = "SELECT email FROM inscrito WHERE email = :email";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':email',$email);
            $stmt->execute();
            $quantidade = count($stmt->fetchAll(PDO::FETCH_ASSOC));
            if($quantidade == 0){
                return true;
            }else{
                return false;
            }
        }catch(Exception $e){
            die("Ocorreu um erro ao realizar sua inscrição");
        }
    }

}