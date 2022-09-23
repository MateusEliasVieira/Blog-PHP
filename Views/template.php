<?php 
    include("config/Config.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/template.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Blog</title>
</head>
<body>
    <header>
        <nav id="navbar" class="navbar navbar-dark bg-dark">
            <div id="box-nav">
                <div id="box-nav-topo">
                    <h2>Somos.Devs</h2>
                    <div id="box-login">
                        <a id="link-login" href="/blog/login">Entrar</a>
                        <img src="/blog/midia/icones/login.png" width="24px" height="24px" alt="ícone login">
                    </div>
                </div>
                <hr>
                <div id="box-nav-base">
                    <div id="box-links">
                        <a class="link link-inicio" href="/blog">Pagina inicial</a>
                        <a class="link" href="">Inscreva-se</a>
                        <a class="link" href="">Contato</a>
                        <a class="link" href="">Sobre</a>
                    </div>
                    <div id="box-redes-sociais">
                        <a class="link-rs" href="">
                            <img src="/blog/midia/icones/twitter-nav.png" width="32px" height="32px" alt="">
                        </a>
                        <a class="link-rs" href="">
                            <img src="/blog/midia/icones/linkedin-nav.png" width="32px" height="32px" alt="">
                        </a>
                        <a class="link-rs" href="">
                            <img src="/blog/midia/icones/youtube-nav.png" width="32px" height="32px" alt="">
                        </a>
                        <a class="link-rs" href="">
                            <img src="/blog/midia/icones/instagram-nav.png" width="32px" height="32px" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </nav>
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