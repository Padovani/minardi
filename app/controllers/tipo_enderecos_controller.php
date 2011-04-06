<?php

class tipo_enderecos extends Controller {
    //put your code here
    public $TipoEndereco=null;

    public function  __construct() {
        parent::__construct();
        $this->TipoEndereco= new TipoEndereco();
    }

    public function  index(){

        if(isset($this->data['post']['tipo'])) {
            $tipo=$this->data['post']['tipo'];
            $sql = "INSERT INTO loja_tipo_endereco (titulo,ativo)
                VALUES('".$this->data['post']['tipo']."','".$this->data['post']['ativo']."')";

           if($this->TipoEndereco->executeQuery($sql)){
               echo "cadastrado com sucesso !!";
           }else echo "Erro ao cadastrar !!";


        }

        $this->autoRender('/tipo_enderecos/index');
    }

}
?>
