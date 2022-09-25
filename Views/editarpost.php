
<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/editarpost.css"/>
<link rel="stylesheet" href="../dist/ui/trumbowyg.min.css">
<?php
    $post = (isset($dados[0]) and is_array($dados[0]) and !empty($dados[0])) ? $dados[0] : array();
    $categorias = (isset($dados[1]) and is_array($dados[1]) and !empty($dados[1])) ? $dados[1] : array();
    $resposta = (isset($dados[2]) and !empty($dados[2])) ? $dados[2] : "";
?>
<section id="section-editar">

    <form id="form-editar" method="post" action="http://localhost/blog/post/atualizar">
         
        <!-- Caso exista algum erro para fazer a postagem, mostrará a mensagem de erro -->
         <?php if(isset($resposta) and !empty($resposta) and is_bool($resposta) and $resposta == true){ ?>
            <div id="alerta-sucesso" class="alert alert-info" role="alert">
                Postagem atualizada com sucesso!
            </div>
            <script type="text/javascript">
                setTimeout(()=>{
                    document.getElementById("alerta-sucesso").style.display = "none";
                },5000);
            </script>
        <?php } else if(isset($resposta) and !empty($resposta) and is_bool($resposta) and $resposta == false){ ?>
            <div id="alerta-sucesso" class="alert alert-danger" role="alert">
                Erro ao atualizar postagem!
            </div>
            <script type="text/javascript">
                setTimeout(()=>{
                    document.getElementById("alerta-sucesso").style.display = "none";
                },5000);
            </script>
        <?php } else if(isset($resposta) and !empty($resposta) and is_string($resposta)){ ?>
            <div id="alerta-erro" class="alert alert-danger" role="alert">
                <?php echo $resposta; ?>
            </div>
            <script type="text/javascript">
                setTimeout(()=>{
                    document.getElementById("alerta-erro").style.display = "none";
                },5000);
            </script>
        <?php } ?>

        <input type="hidden" name="id_postagem" <?php echo "value='".$post['id_postagem']."'";?> >
        <div class="form-floating mb-3">
            <input type="text" class="form-control" maxlength="50" name="titulo" id="floatingInput" required="required" placeholder="name@example.com" <?php echo "value='".$post['titulo']."'"; ?>>
            <label for="floatingInput">Título</label>
        </div>
        <select name="categoria" class="form-select form-select-lg mb-3" aria-label="Default select example" required="required">
            <option selected value="">Selecione a Categoria</option>
            <?php if(isset($categorias) and !empty($categorias)){ ?>
                <?php  foreach($categorias as $categoria){?>
                    <option value="<?php echo $categoria['id_categoria']; ?>">
                        <?php echo $categoria['nome_categoria'];?>
                    </option>
                <?php } ?>
            <?php } ?>
        </select>
        <textarea name="conteudo" id="trumbowyg-editor" rows="5" required="required" placeholder="Conteúdo do artigo">
            <?php echo $post['conteudo']; ?>
        </textarea>
        <input id="btn-atualizar" type="submit" class="btn btn-dark" value="Atualizar" name="SendAtuArtigo" />
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../dist/trumbowyg.min.js"></script>
    <script type="text/javascript" src="../dist/langs/pt_br.min.js"></script>
    <script src="../dist/plugins/emoji/trumbowyg.emoji.min.js"></script>
    <script>
        $('#trumbowyg-editor').trumbowyg({
            lang: 'pt_br',
            btns: [
                ['viewHTML'],
                ['undo', 'redo'], // Only supported in Blink browsers
                ['formatting'],
                ['strong', 'em', 'del'],
                ['superscript', 'subscript'],
                ['link'],
                ['insertImage'],
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                ['unorderedList', 'orderedList'],
                ['horizontalRule'],
                ['removeformat'],
                ['fullscreen'],
                ['emoji']
            ],
            autogrow: true
        });
    </script>
</section>