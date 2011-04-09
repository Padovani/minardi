<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Categoria
 *
 * @author Honjoya
 */
class Categoria extends Model{

   public $_tabela = 'loja_categorias';

   public function getCategoriaLista(){
        return $this->read('all');
   }

   public function getCategoriaTreeList(){
            return $this->generateTreeList(null,'&nbsp&nbsp');
   }

    public function getCategoriaTree(){
        $litas =  $this->generateTreeList(null,'&nbsp&nbsp');
        $categorias = array();

        foreach($litas as $k => $v){
            $c = $this->read('first','loja_categorias.id = '.$k);
            $categorias[$k] = $c;
            $categorias[$k]['nome'] = $v;
        }
        return array('categorias'=>$categorias,'quantidade'=>count($categorias));
   }

   public function categoriaMenu(){
        $categoriasPai = $this->read(null,'parent_id = 0');
        foreach($categoriasPai as $k=>$v){
            $categoriasPai[$k]['filhas'] =  $this->getFilha($v['id'],'');
        }

        return $categoriasPai;
   }
}
?>
