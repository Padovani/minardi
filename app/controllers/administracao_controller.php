<?php
class Administracao extends Controller{

    public function index(){
        $this->set('produtos_minimo',1);
        $this->autoRender("/administracao/index");
    }

    public function entrada(){
         $this->autoRender("/administracao/entrada");
    }
}
?>