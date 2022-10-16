<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/autor.css"/>

<?php
    $autor = (isset($dados) and !empty($dados)) ? $dados : null; 
?>

<section id="section-autor">

    <?php if($autor != null){ ?>

        <div id="box-sobre">
            <div id="topo">
                <h5>Autor - <i><?php echo $autor['nome']; ?></i></h5>
                <div id="box-redes-sociais">
                    <?php if(!empty($autor['twitter'])){ ?>
                        <a class="links-rs" href="<?php echo $autor['twitter']; ?>" target="_blank">
                            <img src="<?php echo INCLUDE_PATH_ICONS; ?>twitter-nav.png" alt="Icone do twitter" width="32px" height="32px">
                        </a>
                    <?php } ?>
                    <?php if(!empty($autor['facebook'])){ ?>
                        <a class="links-rs" href="<?php echo $autor['facebook']; ?>" target="_blank">
                            <img src="<?php echo INCLUDE_PATH_ICONS; ?>facebook-nav.png" alt="Icone do facebook" width="32px" height="32px">
                        </a>
                    <?php } ?>
                    <?php if(!empty($autor['youtube'])){ ?>
                        <a class="links-rs" href="<?php echo $autor['youtube']; ?>" target="_blank">
                            <img src="<?php echo INCLUDE_PATH_ICONS; ?>youtube-nav.png" alt="Icone do youtube" width="32px" height="32px">
                        </a>
                    <?php } ?>
                    <?php if(!empty($autor['instagram'])){ ?>
                        <a class="links-rs" href="<?php echo $autor['instagram']; ?>" target="_blank">
                            <img src="<?php echo INCLUDE_PATH_ICONS; ?>instagram-nav.png" alt="Icone do instagram" width="32px" height="32px">
                        </a>
                    <?php } ?>
                </div>
            </div>
            <div>
                <div id="dados-autor">
                    <img id="imagem-autor" <?php if(!empty($autor['caminho_imagem'])){ echo "src='/blog/".$autor['caminho_imagem']."'"; }else{ echo "src='/blog/midia/uploads/sem-foto.png'";}?> width="200px" height="200px" alt="Imagem do Autor">
                    <h6><?php echo $autor['qtd_postagens']; ?> postagens</h6>
                    <h6><?php echo $autor['qtd_visualizacoes']; ?> views em suas postagens</h6>
                </div>
            </div>
            <div id="meio">
                <?php echo $autor['sobre']; ?>
            </div>
        </div>
        
    <?php }else{ ?>
        <h3>Não informações sobre esse Autor!</h3>
    <?php } ?>


    <?php if(!empty($autor['whatsapp'])){ ?>
        <?php
            $link = "https://wa.me/55".$autor['whatsapp']."?text=Olá ".explode(" ",$autor['nome'])[0].", vim pelo seu perfil do blog Somos.Devs!";
        ?>
        <a id="whatsapp" href="<?php echo $link; ?>" target="_blank">
            <img src="<?php echo INCLUDE_PATH_ICONS; ?>whatsapp2.png" alt="Icone do whatsapp" width="40px" height="40px">
        </a>
    <?php } ?>

</section>