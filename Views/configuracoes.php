<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/configuracoes.css"/>
<link rel="stylesheet" href="../dist/ui/trumbowyg.min.css">
<link rel="stylesheet" href="../dist/ui/trumbowyg.css">
<link rel="stylesheet" href="../dist/plugins/table/ui/trumbowyg.table.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/themes/prism.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/plugins/line-highlight/prism-line-highlight.min.css">
<link rel="stylesheet" href="../dist/plugins/highlight/ui/trumbowyg.highlight.min.css">
<link rel="stylesheet" href="../dist/plugins/colors/ui/trumbowyg.colors.min.css">


<?php
    $usuarioModel = new UsuarioModel();
    $usuario = $usuarioModel->buscarMeusDados();
    $erros = (isset($dados) and is_array($dados) and !empty($dados)) ? $dados : null;
    $resultado = (isset($dados) and is_bool($dados) and !empty($dados)) ? $dados : null;
?>

<section id="section-config">
    <form action="/blog/usuario/usuario" method="post" enctype="multipart/form-data">
        <?php if($resultado != null and $resultado == true){?>
            <div id="alerta-sucesso" class="alert alert-success" role="alert">
                <?php echo "Seus dados foram atualizados com sucesso!";?> 
            </div>
            <script type="text/javascript">
                    setTimeout(function(){
                        document.getElementById("alerta-sucesso").style.display = "none";
                    },5000);
            </script>   
        <?php }else if($resultado != null and $resultado == false){ ?>
            <div id="alerta-erro" class="alert alert-danger" role="alert">
                <?php echo "Não foi possível atualizar seus dados!";?>    
            </div>
            <script type="text/javascript">
                    setTimeout(function(){
                        document.getElementById("alerta-erro").style.display = "none";
                    },5000);
            </script>   
        <?php } ?>
        <h3>Meus dados</h3>

        <?php if($erros != null){?>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Visualizar erros
            </button>

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Erro(s)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php foreach($erros as $erro){?>
                        <div id="alerta-erro" class="alert alert-danger" role="alert">
                            <?php echo $erro; ?>    
                        </div>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Irei concertar</button>
                </div>
                </div>
            </div>
            </div>

        <?php } ?>

        <div class="input-group">
            <input name="nome" class="form-control form-control-lg" type="text" placeholder="Nome (obrigatório)" aria-label=".form-control-lg example" <?php if(isset($_POST['nome'])){ echo "value='".$_POST['nome']."'";}else{echo "value='".$usuario['nome']."'";} ?>>
            <input name="email" class="form-control form-control-lg" type="email" placeholder="Email (obrigatório)" aria-label=".form-control-lg example" <?php if(isset($_POST['email'])){ echo "value='".$_POST['email']."'";}else{echo "value='".$usuario['email']."'";} ?>>
        </div>
        <input name="whatsapp" class="form-control form-control-lg" type="number" placeholder="Whatsapp (Ex: 64911112222)" aria-label=".form-control-lg example" <?php if(isset($_POST['whatsapp'])){ echo "value='".$_POST['whatsapp']."'";}else{echo "value='".$usuario['whatsapp']."'";} ?>>
        <div class="input-group">
            <input name="instagram" class="form-control form-control-lg" type="url" placeholder="Instagram" aria-label=".form-control-lg example" <?php if(isset($_POST['instagram'])){ echo "value='".$_POST['instagram']."'";}else{echo "value='".$usuario['instagram']."'";} ?>>
            <input name="facebook" class="form-control form-control-lg" type="url" placeholder="Facebook" aria-label=".form-control-lg example" <?php if(isset($_POST['facebook'])){ echo "value='".$_POST['facebook']."'";}else{echo "value='".$usuario['facebook']."'";} ?>>
        </div>
        <div class="input-group">
            <input name="twitter" class="form-control form-control-lg" type="url" placeholder="Twitter" aria-label=".form-control-lg example" <?php if(isset($_POST['twitter'])){ echo "value='".$_POST['twitter']."'";}else{echo "value='".$usuario['twitter']."'";} ?>>
            <input name="youtube" class="form-control form-control-lg" type="url" placeholder="YouTube" aria-label=".form-control-lg example" <?php if(isset($_POST['youtube'])){ echo "value='".$_POST['youtube']."'";}else{echo "value='".$usuario['youtube']."'";} ?>>
        </div>
        <div class="input-group">
            <input name="senha" class="form-control form-control-lg" type="password" placeholder="Senha (obrigatório)" aria-label=".form-control-lg example" <?php if(isset($_POST['senha'])){ echo "value='".$_POST['senha']."'";} ?>>
            <input name="repete_senha" class="form-control form-control-lg" type="password" placeholder="Repita a senha (obrigatório)" aria-label=".form-control-lg example" <?php if(isset($_POST['repete_senha'])){ echo "value='".$_POST['repete_senha']."'";} ?>>
        </div>
        <input name="arquivo" type="file" class="form-control" id="inputGroupFile04" title="Selecione sua foto" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
        <textarea name="sobre" id="trumbowyg-editor" class="editor" placeholder="Escreva sobre você!" >
            <?php 
                if(isset($_POST['sobre'])){ 
                    echo $_POST['sobre'];
                } else{ 
                    echo $usuario['sobre'];
                }
            ?>    
        </textarea>
        <input type="submit" name="submit_atualizar" class="btn btn-dark" value="Atualizar">
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