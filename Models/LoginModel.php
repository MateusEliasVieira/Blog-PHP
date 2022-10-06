<?php

require_once "lib/database/Conexao.php";

class LoginModel{

    private $con;

    public function __construct(){
        $this->con = Conexao::getConnection();
    }

    public function verificarLogin(string $email, string $senha){
        if(!empty($email) and !empty($senha)){
            try{
                $stmt = $this->con->prepare("SELECT U.id_usuario,U.token FROM usuario_adm as U WHERE email = :email AND senha = :senha LIMIT 1");
                $stmt->bindValue(':email',$email);
                $stmt->bindValue(':senha',sha1($senha));
                $stmt->execute();
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                if(isset($resultado) and !empty($resultado)){
                    $usuario = new UsuarioEntidade();
                    $usuario->setIdUsuario($resultado['id_usuario']);
                    $usuario->setToken($resultado['token']);
                    return $usuario;
                }else{
                    return false;
                }
            }catch(Exception $e){
                die("Erro ao realizar login!");
            }
        }

    }

}