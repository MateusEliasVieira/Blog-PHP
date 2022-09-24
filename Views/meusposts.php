
<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/meusposts.css"/>

<section id="section-meusposts">
    <div id="box-pesquisa">
        <h3>Minhas postagens</h3>
        <form action="">
            <input class="form-control" type="text" name="titulo-post" placeholder="título">
            <input class="btn btn-dark" type="submit" value="Pesquisar">
        </form>
    </div>
    <div id="box-table">
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
                <?php foreach ($dados as $postagem){?>
                    <tr>
                        <th scope="row"><?php echo $postagem['id_postagem']; ?></th>
                        <td><?php echo $postagem['titulo']; ?></td>
                        <td><?php echo $postagem['curtidas']; ?></td>
                        <td><?php echo $postagem['quantidade_comentarios']; ?></td>
                        <td><?php echo $postagem['data_postagem']; ?></td>
                        <td class="td-opcoes">
                            <form action="http://localhost/blog/post/editar" method="post">
                                <input type="hidden" name="id_postagem" value="<?php echo $postagem['id_postagem'];?>"/>
                                <input class="btn btn-primary" type="submit" value="Editar">
                            </form>
                            <form action="" method="post">
                                <input class="btn btn-danger" type="submit" value="Deletar">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>