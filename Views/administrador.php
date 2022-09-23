
<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/administrador.css"/>
<link rel="stylesheet" href="../dist/ui/trumbowyg.min.css">

<section id="section-adm">

    <form id="form" method="post" action="http://localhost/blog/post/cadastrar">
       
        <!-- Caso exista erro ao fazer upload de imagem -->
        <?php if(isset($dados) and !empty($dados) and is_array($dados)){ ?>
            <div id="alerta-erro" class="alert alert-danger" role="alert">
                <?php foreach($dados as $erro){
                    echo $erro;
                }?>
            </div>
            <script type="text/javascript">
                setTimeout(()=>{
                    document.getElementById("alerta-erro").style.display = "none";
                },5000);
            </script>
        <?php }else if(isset($dados) and !empty($dados) and is_bool($dados) and $dados == true){ ?>
            <div id="alerta-sucesso" class="alert alert-info" role="alert">
                Postagem feita com sucesso!
            </div>
            <script type="text/javascript">
                setTimeout(()=>{
                    document.getElementById("alerta-sucesso").style.display = "none";
                },5000);
            </script>
            <?php } else if(isset($dados) and !empty($dados) and is_string($dados)){?>
            <div id="alerta-erro" class="alert alert-danger" role="alert">
                <?php echo $dados; ?>
            </div>
            <script type="text/javascript">
                setTimeout(()=>{
                    document.getElementById("alerta-erro").style.display = "none";
                },5000);
            </script>
        <?php } ?>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" maxlength="50" name="titulo" id="floatingInput" required="required" placeholder="name@example.com" <?php if(isset($_POST['titulo'])){ echo "value='".$_POST['titulo']."'"; } ?> >
            <label for="floatingInput">Título</label>
        </div>
        <select name="categoria" class="form-select form-select-lg mb-3" aria-label="Default select example" required="required">
            <option selected value="">Selecione a Categoria</option>
            <option value="1">Anuncios</option>
            <option value="2">Html</option>
            <option value="3">Css</option>
        </select>
        <textarea name="conteudo" id="trumbowyg-editor" rows="5" required="required" placeholder="Conteúdo do artigo">
            <?php 
                if(isset($_POST['conteudo'])){ 
                    echo $_POST['conteudo']; 
                } 
            ?>
        </textarea>
        <input id="btn-submit" type="submit" class="btn btn-success" value="Postar" name="SendCadArtigo" />
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

