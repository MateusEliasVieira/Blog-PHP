<?php 
    include("config/Config.php");
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
             <!-- Botão que aciona o menu -->
            <button id="btn-menu" class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                Menu
            </button>
            <ul>
                <li>Administrador</li>
                <li><a href="/blog/login">Sair</a></li>
            </ul>
        </nav>
        <!-- Menu -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Opções</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <!-- <div>
                    Some text as placeholder. In real life you can have the elements you have chosen. Like, text, images, lists, etc.
                </div> -->
                <div class="dropdown mt-3">
                <button id="btn-opcoes" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                   Selecione
                </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="http://localhost/blog/post/admin">Novo Post</a></li>
                        <li><a class="dropdown-item" href="http://localhost/blog/post/meusposts">Meus Posts</a></li>
                        <li><a class="dropdown-item" href="#">Add Usuário</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>


<?php
    $this->carregarViewNoTemplate($nome_view,$dados);
?>

    

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