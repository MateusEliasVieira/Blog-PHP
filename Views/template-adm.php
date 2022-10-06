<?php 
    include("config/Config.php");
?>
<?php
    $usuarioModel = new UsuarioModel();
    $usuario = $usuarioModel->buscarMeusDados();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/template-adm.css"/>
    <title>Blog</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li id="li-adm">Administrativo</li>
                <li><a id="sair-adm" href="/blog/login/encerrar">Sair</a></li>
            </ul>
        </nav>
        <div id="box-container-administrativo">
     
            <section id="menu-administrativo">
                <div id="dados-administrador">
                    <img <?php if(!empty($usuario['caminho_imagem']) and $usuario['caminho_imagem'] != null){ echo "src='/blog/".$usuario['caminho_imagem']."'";}else{ echo "src='/blog/midia/uploads/author-somos-devs.jpg'";} ?>  width="120px" height="120px" alt="Imagem do administrador">
                    <h6><?php echo $usuario['nome']; ?></h6>
                </div>
                <ul>
                    <li class="li-titulo">Administrador</li>
                    <li><a class="link-opcao" href="http://localhost/blog/usuario/administrador">Informações</a></li>
                    <li class="li-titulo">Postagem</li>
                    <li><a class="link-opcao" href="http://localhost/blog/usuario/novopost">Nova postagem</a></li>
                    <li><a class="link-opcao" href="http://localhost/blog/usuario/meusposts">Minhas postagens</a></li>
                    <li class="li-titulo">Usuários</li>
                    <li><a class="link-opcao" href="#">Adicionar usuário</a></li>
                    <li><a class="link-opcao" href="#">Listar usuários</a></li>
                    <li class="li-titulo">Perfil</li>
                    <li><a class="link-opcao" href="http://localhost/blog/usuario/configuracoes">Configurações</a></li>

                </ul>
            </section>
            <?php
                $this->carregarViewNoTemplate($nome_view,$dados);
            ?>
        </div>
    </header>




    

    <footer>
        <div id="box-info-footer">
            <div id="box-contato">
                <a href="">
                    <img src="/blog/midia/icones/instagram.png" width="40px" alt="ícone instagram">
                </a>
                <a href="">
                    <img src="/blog/midia/icones/youtube.png" width="40px" alt="ícone youtube">
                </a>
                <a href="">
                    <img src="/blog/midia/icones/whatsapp.png" width="40px" alt="ícone whatsapp">
                </a>
            </div>
            <div id="box-descricao">
                <h6>Info . Suport . Marketing</h6>
                <h6>Terms of use . Privacy Policy</h6>
                <h6 id="h6-copy">&copy; 2022 SomosDevs</h6>
            </div>
        </div>
    </footer>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    
</body>
</html>