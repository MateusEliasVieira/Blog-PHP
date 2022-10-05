
<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/novopost.css"/>
<link rel="stylesheet" href="../dist/ui/trumbowyg.min.css">
<link rel="stylesheet" href="../dist/ui/trumbowyg.css">
<link rel="stylesheet" href="../dist/plugins/table/ui/trumbowyg.table.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/themes/prism.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/plugins/line-highlight/prism-line-highlight.min.css">
<link rel="stylesheet" href="../dist/plugins/highlight/ui/trumbowyg.highlight.min.css">
<link rel="stylesheet" href="../dist/plugins/colors/ui/trumbowyg.colors.min.css">

<?php
    $categorias = (isset($dados[0]) and is_array($dados[0]) and !empty($dados[0])) ? $dados[0] : array();
    $resposta = (isset($dados[1]) and !empty($dados[1])) ? $dados[1] : "";
?>

<section id="section-novo-post">
    
    <form id="form" method="post" action="http://localhost/blog/usuario/cadastrar">
        <h3>Nova Postagem</h3>
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
        <textarea name="conteudo" id="trumbowyg-editor" class="editor" required="required" placeholder="Conteúdo do artigo">
            <?php 
                if(isset($_POST['conteudo'])){ 
                    echo html_entity_decode($_POST['conteudo']); 
                } 
            ?>
        </textarea>
        <input id="btn-submit" type="submit" class="btn btn-dark" value="Postar" name="submit_cadastrar" />
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../dist/trumbowyg.min.js"></script>
    <script type="text/javascript" src="../dist/langs/pt_br.min.js"></script>
    <script src="../dist/plugins/emoji/trumbowyg.emoji.min.js"></script>
    <script src="../dist/plugins/fontfamily/trumbowyg.fontfamily.min.js"></script>
    <script src="../dist/plugins/fontsize/trumbowyg.fontsize.min.js"></script>
    <script src="../dist/plugins/table/trumbowyg.table.min.js"></script>
    <script src="../dist/plugins/resizimg/trumbowyg.resizimg.min.js"></script>
    <script src="//rawcdn.githack.com/RickStrahl/jquery-resizable/0.35/dist/jquery-resizable.min.js"></script>
    <script src="../dist/plugins/noembed/trumbowyg.noembed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/plugins/line-highlight/prism-line-highlight.min.js"></script>
    <script src="../dist/plugins/highlight/trumbowyg.highlight.min.js"></script>
    <script src="../dist/plugins/colors/trumbowyg.colors.min.js"></script>


    <script>

        var colorLabels = {
            '#000': 'Preto',
            '#555': 'Cinza escuro',
            '#ff0000': 'Vermelho',
            '#00ff00': 'Verde',
            '#0000ff': 'Azul',
            '#ff1493': 'Rosa',
            '#ffff00': 'Amarelo',
            '#ff8000': 'Laranja'
        };

        $.each(colorLabels, function(colorHexCode, colorLabel) {
            $.trumbowyg.langs.en[colorHexCode] = colorLabel;
        })

        $('#trumbowyg-editor').trumbowyg({
            lang: 'pt_br',
            btns: [
                ['viewHTML'],
                ['undo', 'redo'], // Only supported in Blink browsers
                ['fontfamily','fontsize','foreColor', 'backColor'],
                ['formatting'],
                ['strong', 'em', 'del'],
                ['superscript', 'subscript'],
                ['link'],
                ['insertImage','noembed'],
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                ['unorderedList', 'orderedList'],
                ['horizontalRule'],
                ['highlight'],
                ['table'],
                ['removeformat'],
                ['fullscreen'],
                ['emoji']
                
            ],
            plugins: {
                    fontfamily: {
                        fontList: [
                            {name: 'Arial', family: 'Arial, Helvetica, sans-serif'},
                            {name: 'Comic Sans', family: '\'Comic Sans MS\', Textile, cursive, sans-serif'},
                            {name: 'Open Sans', family: '\'Open Sans\', sans-serif'},
                            {name: 'Times New Roman', family: 'Serif'},
                            {name: 'Didot', family: 'Serif'},
                            {name: 'Helvética', family: 'sans-serif'},
                            {name: 'Courier', family: 'Monospace'},
                            {name: 'Star Wars', family: 'Fantasy'},
                            {name: 'Zapf-Chancery', family: 'Cursive'},
                            {name: 'Arial Narrow', family: 'Arial'},
                            {name: 'Geneva', family: 'sans-serif'},

                        ]
                    },
                    resizimg: {
                        minSize: 64,
                        step: 16,
                    },
                    fontsize: {
                        sizeList: [
                            '12px',
                            '14px',
                            '16px',
                            '20px',
                            '22px',
                            '24px',
                            '26px'
                        ]
                    },
                    table: {
                            // Some table plugin options, see details below
                    },
                    colors: {
                        foreColorList: [
                            'ffff00','555','000','ff0000', '00ff00', '0000ff', 'ff1493','ff8000'
                        ],
                        backColorList: [
                            'ffff00','555','000','ff0000', '00ff00', '0000ff', 'ff1493','ff8000'
                        ],
                        displayAsList: true
                    },
                    giphy: {
                        apiKey: 'xxxxxxxxxxxx'
                    }
                   
                },
            autogrow: true
        });

    </script>
 
</section>

