<?php

session_start();

class LoginController extends Controller{

    private $usuario;

    public function index(){
        $this->carregarTemplate("login",array());
    }

    public function logar(){
       
        if(!isset($_SESSION['token']) and !isset($_SESSION['id_usuario'])){

            if((isset($_POST["email"]) and !empty($_POST["email"])) and (isset($_POST["senha"]) and !empty($_POST["senha"]))){
               
                $email = $this->limparEntradaDeDados($_POST['email']);
                $senha = $this->limparEntradaDeDados($_POST['senha']);
               
                $loginModel = new LoginModel();
                $this->usuario = $loginModel->verificarLogin($email,$senha);
               
                if(isset($this->usuario) and !empty($this->usuario)){
                    $_SESSION['token'] = $this->usuario->getToken();
                    $_SESSION['id_usuario'] = $this->usuario->getIdUsuario();
                    header('Location: http://localhost/blog/usuario/administrador');
                }else if($this->usuario == false){
                    // Usuario não encontrado
                    $erro['erro_login'] = "Email ou senha inválidos!";
                    $this->carregarTemplate("login",$erro);
                }
                
            }else{
                // Post Vazio
                $erro['erro_login'] = "Preencha todos os campos!";
                $this->carregarTemplate("login",$erro);
            }

        }else{
            // Já existe sessão
            header('Location: http://localhost/blog/usuario/administrador');
        }
    }
    
    // Encerra uma sessão
    public function encerrar(){
        session_start();
        session_unset();
        session_destroy();
        $this->index();
    }

    private function limparEntradaDeDados($valor){
        $valor = trim($valor);
        $valor = stripslashes($valor);
        $valor = htmlspecialchars($valor);
        return $valor;
    }

}