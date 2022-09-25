
<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/post.css"/>

<section id="section-post">

    <!-- Card da Postagem -->
    <div id="box-post">
        <div>
            <h2><?php echo $dados[0]['titulo']; ?></h2>
            <p><?php echo $dados[0]['conteudo']; ?></p>
            <p>
                <?php 
                    $data_hora = explode(" ",$dados[0]['data_postagem']);
    
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
        
        <!-- Rodapé do card da Postagem -->
        <div id="box-info-post">
            <form method="post" action="http://localhost/blog/post/curtir">
                <div id="box-curtir">
                    <input id="input-curtir" type="submit" name="submit_curtir" title="Curtir postagem" value=""/> 
                    <span id="span-curtida"> 
                        <?php echo $dados[0]['curtidas']." curtidas"; ?> 
                    </span>
                </div>
                <input type="hidden" name="titulo" value="<?php echo $dados[0]['titulo']; ?>">
                <input type="hidden" name="id_postagem" value="<?php echo $dados[0]['id_postagem']?>"/>
            </form>
            <div class="box-sobre-post">
                <img src="/blog/midia/icones/comentarios.png" alt="ícone de comentários" width="24px" height="24px"/>
                <span id="span-comentarios"> <?php echo $dados[0]['quantidade_comentarios']; ?> comentários</span>
            </div>
        </div>
    </div>

    <!-- Box de comentários da postagem -->
    <div id="box-comentarios-usuario">

        <h3 id="titulo-comentarios">Comentários</h3>

        <?php foreach ($dados[1] as $comentario) { ?>

            <?php if(isset($comentario['id_comentario'])){?>
                <div class="comentario">
                    <h6><?php echo $comentario['nome']; ?></h6>
                    <p class="p-conteudo"><?php echo $comentario['mensagem']; ?></p>
                    <p class="p-data">
                        <?php 
                            $data_hora = explode(" ",$comentario['data_comentario']);

                            $data = $data_hora[0];
                            $horario = $data_hora[1];
                                   
                            $data = explode("-",$data);
                            $horario = explode(":",$horario);
                        
                            $data_formatada = $data[2]."/".$data[1]."/".$data[0];
                            $horario_formatado = $horario[0].":".$horario[1];
                                    
                            echo "Comentado em ".$data_formatada." às ".$horario_formatado;
                        ?>
                    </p>
                </div>
            <?php } else{ ?>
                <p>Ainda não existe comentários para este post!</p>
            <?php } ?>
        <?php } ?>
    </div>

    <!-- Box do formulário para comentar sobre a postagem -->
    <div id="box-comentar-post">
        <form action="http://localhost/blog/post/comentar" method="post">
            
            <?php if(isset($dados[2]) and !empty($dados[2])){?>
                <div id="alerta-erro" class="alert alert-danger" role="alert">
                    <?php echo $dados[2];?>
                </div>
                <script type="text/javascript">
                    setTimeout(()=>{
                        let componente = document.getElementById("alerta-erro");
                        componente.style.display = "none";
                    },10000);
                </script>
            <?php }?>
            
            <h3 id="titulo-opiniao">Conte-nos sua opinião</h3>
            <div class="form-floating mb-3">
                <input type="Nome" class="form-control" name="nome" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Nome</label>
            </div>
            <div class="form-floating">
                <textarea class="form-control" name="comentario" placeholder="Leave a comment here" id="floatingTextarea" style="height: 200px"></textarea>
                <label for="floatingTextarea">Deixe aqui seu comentário</label>
            </div>

            <input type="hidden" name="id_postagem" value="<?php echo $dados[0]['id_postagem']; ?>">
            <input type="hidden" name="titulo" value="<?php echo $dados[0]['titulo']; ?>">

            <input id="btn-comentar" class="btn btn-dark" type="submit" name="submit_enviar_comentario" value="Publicar">
        </form>
    </div>
</section>