
<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/administrador.css"/>
<link rel="stylesheet" href="../dist/ui/trumbowyg.min.css">
<?php
    $categorias = (isset($dados[0]) and is_array($dados[0]) and !empty($dados[0])) ? $dados[0] : array();
    $resposta = (isset($dados[1]) and !empty($dados[1])) ? $dados[1] : "";
?>
<section id="section-adm">
    <form id="form" method="post" action="http://localhost/blog/post/cadastrar">
       
       <!-- Caso exista algum erro para fazer a postagem, mostrará a mensagem de erro -->
        <?php if(isset($resposta) and !empty($resposta) and is_bool($resposta) and $resposta == true){ ?>
            <div id="alerta-sucesso" class="alert alert-info" role="alert">
                Postagem feita com sucesso!
            </div>
            <script type="text/javascript">
                setTimeout(()=>{
                    document.getElementById("alerta-sucesso").style.display = "none";
                },5000);
            </script>
        <?php } else if(isset($resposta) and !empty($resposta) and is_bool($resposta) and $resposta == false){ ?>
            <div id="alerta-sucesso" class="alert alert-danger" role="alert">
                Erro ao fazer postagem!
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

        <div class="form-floating mb-3">
            <input type="text" class="form-control" maxlength="50" name="titulo" id="floatingInput" required="required" placeholder="name@example.com" <?php if(isset($_POST['titulo'])){ echo "value='".$_POST['titulo']."'"; } ?> >
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
        <textarea name="conteudo" id="ckeditor" required="required" placeholder="Conteúdo do artigo">
            <?php 
                if(isset($_POST['conteudo'])){ 
                    echo $_POST['conteudo']; 
                } 
            ?>
        </textarea>
        <input id="btn-submit" type="submit" class="btn btn-dark" value="Postar" name="submit_cadastrar" />
    </form>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
    </script> -->
    <script src="/blog/vendor/ckeditor/build/ckeditor.js"></script>
	<script>ClassicEditor
			.create( document.querySelector( '#ckeditor' ), {			
				licenseKey: '',			
			} )
			.then( editor => {
					window.editor = editor;				
			} )
			.catch( error => {
				console.error( 'Oops, something went wrong!' );
				console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
				console.warn( 'Build id: hgw637q8k2yp-fb809xrcsyrn' );
				console.error( error );
			} );
	</script>
</section>

