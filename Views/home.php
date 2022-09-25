
<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/home.css"/>
<?php
    $usuario_postagens = (isset($dados[0]) and is_array($dados[0]) and !empty($dados[0])) ? $dados[0] : array();
    $destaques = (isset($dados[1]) and is_array($dados[1]) and !empty($dados[1])) ? $dados[1] : array();
    $categorias = (isset($dados[2]) and is_array($dados[2]) and !empty($dados[2])) ? $dados[2] : array();
?>

<section id="section-home"> 

    <!-- Lado esquerdo da página -->
    <div id="box-left">

        <!-- Cards de Postagens -->
        <?php if(isset($usuario_postagens) and !empty($usuario_postagens)){?>

            <?php foreach ($usuario_postagens as $usuario_postagem){?>
                <div class="post-home">
                    <div class="box-post-chapeu">
                        <p class="p-data">
                            <?php 
                                $data_hora = explode(" ",$usuario_postagem['data_postagem']);
        
                                $data = $data_hora[0];
                                $horario = $data_hora[1];
            
                                $data = explode("-",$data);
                                $horario = explode(":",$horario);

                                $data_formatada = $data[2]."/".$data[1]."/".$data[0];
                                $horario_formatado = $horario[0].":".$horario[1];
                
                                echo "Postado em ".$data_formatada." às ".$horario_formatado;
                            ?>
                        </p>
                    </div>

                    <div class="box-conteudo-post">
                        <a class="link-post title" <?php echo 'href="/blog/post/exibir/'.str_replace(" ","-",$usuario_postagem['titulo']).'"'; ?>> <?php echo $usuario_postagem['titulo']; ?> </a>
                        <div class="content-post"> 
                            <?php echo $usuario_postagem['conteudo']; ?>
                        </div>
                    </div>

                    <div class="box-button">
                        <a <?php echo 'href="/blog/post/exibir/'.str_replace(" ","-",$usuario_postagem['titulo']).'"'; ?> class="btn-ler-mais">Leia mais</a>
                        <div class="informacoes-do-post">
                            <div >
                                <img src="/blog/midia/icones/coracao2.png" width="24px" alt="">
                                <span><?php echo $usuario_postagem['curtidas'];?></span>
                            </div>
                            <div >
                                <img src="/blog/midia/icones/comentario.png" width="24px" alt="">
                                <span><?php echo $usuario_postagem['quantidade_comentarios'];?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php }else{ ?>
            <h3>Sem postagens no momento!</h3>
        <?php } ?>

    </div>

    <!-- Lado direito da página -->
    <div id="box-right"> 

        <!-- Card de Pesquisa -->            
        <div id="search-home">  
            <div class="box-chapeu">
                <h3>Pesquisar</h3>
            </div>
            <div id="box-inputs">
                <form action="home/busca" method="get">
                    <input type="text" class="form-control" placeholder="Título">
                    <input type="submit" value="Pesquisar" class="btn btn-dark">
                </form>
            </div>
        </div>

        <!-- Card de Destaque -->            
        <div id="destaque-home">  
            <div class="box-chapeu">
                <h3>Recentes</h3>
            </div>
            <?php foreach ($destaques as $postagem){?>
                <div class="box-destaque">
                    <p>
                        <?php 
                            $data_hora = explode(" ",$postagem['data_postagem']);
        
                            $data = $data_hora[0];
                            $horario = $data_hora[1];
            
                            $data = explode("-",$data);
                            $horario = explode(":",$horario);

                            $data_formatada = $data[2]."/".$data[1]."/".$data[0];
                            $horario_formatado = $horario[0].":".$horario[1];
                
                            echo $data_formatada." às ".$horario_formatado;
                        ?>
                    </p>
                    <h4 class="title-destaque-post"> <a class="link-title-destaque-post" <?php echo 'href="/blog/post/exibir/'.str_replace(" ","-",$postagem['titulo']).'"'; ?>> <?php echo $postagem['titulo']; ?> </a> </h4>
                </div>
            <?php } ?>
        </div>

        <!-- Card de Categoria -->            
        <div id="categoria-home">  
            <div class="box-chapeu">
                <h3>Categorias</h3>
            </div>
            <?php foreach ($categorias as $categoria){?>
                <div class="box-categoria">
                    <h4 class="title-categoria-post"> 
                        <a class="link-title-categoria-post" href="/blog/post/categoria/<?php echo $categoria['nome_categoria']; ?>">
                            <?php echo $categoria['nome_categoria'];?>
                        </a>
                    </h4>
                </div>
            <?php } ?>
        </div>

    </div>

</section>
