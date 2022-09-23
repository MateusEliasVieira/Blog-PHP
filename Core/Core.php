<?php 

class Core{

    private array $array_url;
    private string $classe_controller;
    private string $metodo_classe_controller;
    private string $parametro_metodo_classe_controller;

    public function __construct(){
        $this->iniciar();
    }

    public function iniciar(){

        // se o parametro da url existir
        if(isset($_GET['url'])){

            if(!empty($_GET['url'])){

                // Limpando a url
                $url = strip_tags(filter_input(INPUT_GET, 'url',FILTER_DEFAULT));

                // separando os parametros passados pela url
                // a função array_filter remove qualquer posição do array que estiver vazio
                $this->array_url = array_filter(explode("/",$url));
                    
                // Verificamos os 3 possíveis caso da url
                // 1º caso - Apenas a classe foi passada
                // 2º caso - Classe e metodo foi passado
                // 3º caso - Classe, metodo e parametro do método foi passado
                    
                // 1º caso
                if(isset($this->array_url[0]) and !isset($this->array_url[1]) and !isset($this->array_url[2])){
                    $this->classe_controller = ucfirst($this->array_url[0]."Controller");
                    $this->metodo_classe_controller = "index";
                }
                // 2º caso
                if(isset($this->array_url[0]) and isset($this->array_url[1]) and !isset($this->array_url[2])){
                    $this->classe_controller = ucfirst($this->array_url[0]."Controller");
                    $this->metodo_classe_controller = $this->array_url[1];
                }
                // 3º caso
                if(isset($this->array_url[0]) and isset($this->array_url[1]) and isset($this->array_url[2])){
                    $this->classe_controller = ucfirst($this->array_url[0]."Controller");
                    $this->metodo_classe_controller = $this->array_url[1];
                    $this->parametro_metodo_classe_controller = $this->array_url[2];
                }

            }else{
                // se os parametros da url estiver 100% vazio
                $this->classe_controller = "PostController";
                $this->metodo_classe_controller = "index";
            }

        }else{
            $this->classe_controller = "PostController";
            $this->metodo_classe_controller = "index";
        }

        // obtendo o caminho do arquivo (classe controller)
        $caminho_classe = './Controllers/'.$this->classe_controller.'.php';

        // Verificando se existe o arquivo e seu método
        if(!file_exists($caminho_classe) and !method_exists($this->classe_controller,$this->metodo_classe_controller)){              
            $this->classe_controller = "ErroController";
            $this->metodo_classe_controller = "erro";
        }else if(file_exists($caminho_classe) and !method_exists($this->classe_controller,$this->metodo_classe_controller)){ 
            $this->classe_controller = "ErroController";
            $this->metodo_classe_controller = "erro";
        }

        // instancio a classe controller
        $obj = new $this->classe_controller;
        
        // caso tenha parametros para o metodo
        if(!empty($this->parametro_metodo_classe_controller)){
            call_user_func_array(array($obj, $this->metodo_classe_controller), array($this->parametro_metodo_classe_controller));
        }else{
            // caso não tenha parametros para o metodo
            call_user_func_array(array($obj, $this->metodo_classe_controller), array());
        }

    }

}