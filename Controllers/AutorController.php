<?php

class AutorController extends Controller{

    public function exibir($nome_autor) {
        $nome_autor = $this->limparEntradaDeDados($nome_autor);
        $nome_autor = str_replace("-", " ", $nome_autor);
        $usuarioModel = new UsuarioModel();
        $autor = $usuarioModel->buscarUsuario($nome_autor);
        $postModel = new PostModel();
        $autor['qtd_postagens'] = $postModel->qtdPostagemUsuario($nome_autor);
        $autor['qtd_visualizacoes'] = $postModel->buscarQuantidadeDeVisualizacoes($nome_autor);
        // $qtd_visualizacoes = null;
         
        $this->carregarTemplate("autor",$autor);
    }

}