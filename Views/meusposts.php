<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/meusposts.css"/>

<?php 
    $postagens = (isset($dados[0]) and !empty($dados[0]) and is_array($dados[0])) ? $dados[0] : null;
    $resultado = (isset($dados[1]) and !empty($dados[1]) and $dados[1] != null and is_bool($dados[1])) ? $dados[1] : null;
?>

<section id="section-meusposts">
    <?php if($postagens != null){ ?>
        <div id="box-pesquisa">
            <h3>Minhas postagens</h3>
            <form action="">
                <input class="form-control" type="text" name="titulo-post" placeholder="título">
                <input class="btn btn-dark" type="submit" value="Pesquisar">
            </form>
        </div>
        <div id="box-table">
            <?php if($resultado != null and $resultado == true){ ?>
                <div id="alerta-sucesso" class="alert alert-success" role="alert">
                    Postagem deletada com sucesso!
                </div>
                <script type="text/javascript">
                    setTimeout(()=>{
                        document.getElementById("alerta-sucesso").style.display = "none";
                    },5000);
                </script>
            <?php }else if($resultado != null and $resultado == false){ ?>
                <div id="alerta-erro" class="alert alert-danger" role="alert">
                    Não foi possível deletar a postagem!
                </div>
                <script type="text/javascript">
                    setTimeout(()=>{
                        document.getElementById("alerta-erro").style.display = "none";
                    },5000);
                </script>
            <?php } ?>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Título</th>
                        <th scope="col">Curtidas</th>
                        <th scope="col">Comentários</th>
                        <th scope="col">Data de Postagem</th>
                        <th scope="col">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($postagens as $postagem){?>
                        <tr>
                            <th scope="row"><?php echo $postagem['id_postagem']; ?></th>
                            <td><?php echo $postagem['titulo']; ?></td>
                            <td><?php echo $postagem['curtidas']; ?></td>
                            <td><?php echo $postagem['quantidade_comentarios']; ?></td>
                            <td><?php echo $postagem['data_postagem']; ?></td>
                            <td class="td-opcoes">
                                <form action="http://localhost/blog/usuario/editar" method="post">
                                    <input type="hidden" name="id_postagem" value="<?php echo $postagem['id_postagem'];?>"/>
                                    <input class="btn btn-primary" type="submit" value="Editar">
                                </form>
                                <form action="http://localhost/blog/usuario/excluir" method="post">
                                    <input type="hidden" name="id_postagem" value="<?php echo $postagem['id_postagem'];?>"/>
                                    <input class="btn btn-danger" type="submit" value="Excluir">
                                </form>            
                            </td>
                        </tr>
                        
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php }else{ ?>
        <h3 style="text-align:center;margin:50px auto;">Você ainda não publicou nenhuma postagem!</h3>
    <?php } ?>

</section>
