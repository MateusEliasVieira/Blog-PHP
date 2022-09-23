
<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/editarpost.css"/>
<link rel="stylesheet" href="../dist/ui/trumbowyg.min.css">

<section id="section-editar">

    <form id="form-editar" method="post" action="http://localhost/blog/post/atualizar" enctype="multipart/form-data">
             
        <?php if(isset($dados) and !empty($dados) and is_string($dados)){?>
            <div id="alerta-erro" class="alert alert-danger" role="alert">
                <?php echo $dados; ?>
            </div>
            <script type="text/javascript">
                setTimeout(()=>{
                    document.getElementById("alerta-erro").style.display = "none";
                },5000);
            </script>
        <?php } ?>


        <input type="hidden" name="id-postagem-atualizar" <?php echo "value='".$dados['id_postagem']."'";?> >
        <div class="form-floating mb-3">
            <input type="text" class="form-control" maxlength="50" name="titulo" id="floatingInput" required="required" placeholder="name@example.com" <?php echo "value='".$dados['titulo']."'"; ?>>
            <label for="floatingInput">Título</label>
        </div>
        <textarea name="conteudo" id="trumbowyg-editor" rows="5" required="required" placeholder="Conteúdo do artigo">
            <?php echo $dados['conteudo']; ?>
        </textarea>
        <div id="input-file" class="input-group">
            <input type="file" name="imagem" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
        </div>
        <input id="btn-atualizar" type="submit" class="btn btn-success" value="Atualizar" name="SendAtuArtigo" />
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