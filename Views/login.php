<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/login.css"/>

<section id="section-login">
    <form id="form-login" action="http://localhost/blog/login/logar" method="post">
        <legend>Identifique-se</legend>
        <?php
            if(isset($dados['erro_login']) and !empty($dados['erro_login'])){ ?>
                <span id="msg-erro"><?php echo $dados['erro_login']; ?></span>
        <?php }?>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" name="senha" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Senha</label>
        </div>
        <input type="submit" value="Entrar" name="submit" class="btn btn-dark">
    </form>
</section>