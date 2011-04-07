<?php
class Index extends controller{
    private $LojaCategoria;

    public function index(){
        $this->LojaCategoria = new Categoria();
        $this->set('categorias',$this->categoriasMenu());
        $this->layout = 'front_end';
        $this->autoRender('index/index');
    }

    private function categoriasMenu(){
        $categoriasPai = $this->LojaCategoria->read(null,'parent_id = 0');
        foreach($categoriasPai as $k=>$v){
            $categoriasPai[$k]['filhas'] =  $this->LojaCategoria->getFilha($v['id'],'');
        }

        return $categoriasPai;
    }

}
?>
