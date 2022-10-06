<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/administrador.css"/>

<?php  
    $qtd_usuario = (isset($dados[0]) and !empty($dados[0])) ? $dados[0] : null;
    $qtd_categoria = (isset($dados[1]) and !empty($dados[1])) ? $dados[1] : null;
    $qtd_postagem = (isset($dados[2]) and !empty($dados[2])) ? $dados[2] : null;
?>

<section id="section-adm">
    <div class="box">
        <div class="box-card user">
            <h4>Usuários</h4>
            <h4>
                <?php 
                    if($qtd_usuario != null){
                        echo $qtd_usuario;
                    }else{
                        echo "Não há usuários!";
                    }
                ?>
            </h4>
        </div>
        <div class="box-card categoria">
            <h4>Categorias</h4>
            <h4>
                <?php 
                    if($qtd_categoria != null){
                        echo $qtd_categoria;
                    }else{
                        echo "Não há categorias!";
                    }
                ?>
            </h4>
        </div>
        <div class="box-card post">
            <h4>Postagens</h4>
            <h4>
                <?php 
                    if($qtd_postagem != null){
                        echo $qtd_postagem;
                    }else{
                        echo "Não há postagens!";
                    }
                ?>
            </h4>
        </div>
    </div>

    <div>
        
    </div>
</section>

